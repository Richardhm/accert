<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administradoras;
use App\Models\ComissoesCorretoresDefault;
use App\Models\ComissoesCorretoresParceiros;
use App\Models\ComissoesCorretoresPersonalizados;

use App\Models\ComissoesCorretoresConfiguracoes;
use App\Models\ComissoesCorretoraConfiguracoes;

use App\Models\TabelaOrigens;
use App\Models\Tabela;
use App\Models\User;
use App\Models\AdministradoraPlanos;

use Illuminate\Http\Request;
use App\Models\Corretora;
use App\Models\Planos;
use App\Http\Requests\StoreUpdateCorratora;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Cargo;

use App\Models\cidadeCodigoVendedor;


class CorretoraController extends Controller
{
     private $repository;

    public function __construct(Corretora $corretora)
    {
        $this->repository = $corretora;
    }

    public function index()
    {
        $cargos = Cargo::all();
        $tabela_origens = TabelaOrigens::all();
        $users = User::all();
        $logo = null;
        $corretora = $this->repository->first();
        if($corretora->logo) $logo = 'storage/'.$corretora->logo;

        $admins = Administradoras::where("nome","!=","Hapvida")->get();
        $admins_all = Administradoras::all();
        $planos_all = Planos::all();

        $cidade_corretora = ComissoesCorretoraConfiguracoes::select('planos.nome','planos.id')
        ->join('planos', 'comissoes_corretora_configuracoes.plano_id', '=', 'planos.id')
        ->groupBy('comissoes_corretora_configuracoes.plano_id')
        ->get();

        $planos = DB::select("
            SELECT id,nome
            FROM planos
            WHERE nome NOT LIKE '%Coletivo por Adesão%'
        ");

        $personalizados = ComissoesCorretoresPersonalizados
        ::join('users', 'users.id', '=', 'comissoes_corretores_personalizado.user_id')
        ->select('users.name','users.id')
        ->groupBy('comissoes_corretores_personalizado.user_id')
        ->get();

        return view('admin.pages.corretora.index',[
            "cidades" => $tabela_origens,
            "users" => $users,
            "corretora" => $corretora,
            "administradoras" => $admins,
            "personalizados" => $personalizados,
            "planos" => $planos,
            "administradoras_all" => $admins_all,
            "planos_all" => $planos_all,
            "logo" => $logo,
            "cargos" => $cargos,
            "cidade_corretora" => $cidade_corretora
        ]);
    }

    public function corretoraListaCidade(Request $request)
    {        
        $dados = ComissoesCorretoraConfiguracoes
        ::select(
            'comissoes_corretora_configuracoes.id as id',
            'administradoras.nome as administradora',
            'planos.nome as plano','valor',
            'planos.id as plano_id',
            'administradoras.id as administradora_id'
            )
        ->join('administradoras','administradoras.id',"=",'comissoes_corretora_configuracoes.administradora_id')
        ->join('planos','planos.id',"=",'comissoes_corretora_configuracoes.plano_id')
        //->where("comissoes_corretora_configuracoes.plano_id",$request->id)
        ->get();

        return view('admin.pages.home.corretora-cidade',[
            'dados' => $dados
        ]);
    }

    public function corretoraMudarLogo(Request $request)
    {
        $corretora = $this->repository->first();

        if($corretora->logo && file_exists("storage/".$corretora->logo)) {
            unlink("storage/".$corretora->logo);
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        

        $filename = uniqid().".".$extension;
        $location = 'storage';
        $uploadedFile = $file->move($location, $filename);
        $logo = $filename;
        
        $corretora->logo = $logo;
        $corretora->save();

        



    }



    public function verificarPlanosHap(Request $request)
    {
        


        if($request->tipo == 1) {
            $dados = ComissoesCorretoresDefault::where("plano_id",$request->plano)->where("administradora_id",4)->where("tabela_origens_id",$request->cidade);
            if($dados->count() >= 1) {
                return $dados->get();
            } else {
                return "";
            }
        } else if($request->tipo == 2) {
            $dados = ComissoesCorretoresParceiros::where("plano_id",$request->plano)
                ->where("administradora_id",4)
                ->where("tabela_origens_id",$request->cidade);

            if($dados->count() >= 1) {
                return $dados->get();
            } else {
                return "";
            }
        } else {           
            $administradora = ($request->administradora != null ? $request->administradora : 4);
            $dados = ComissoesCorretoresPersonalizados
                ::where("plano_id",$request->plano)
                ->where("administradora_id",$administradora)
                ->where("tabela_origens_id",$request->cidade)
                ->where("user_id",$request->user_id);
            if($dados->count() >= 1) {
                return $dados->select('valor')->get();    
            } else {
                return "";
            }                    
        }
        
    }


    public function corretoresCadastrarPlanos(Request $request)
    {
        
        $nome = $request->nome;
        $empresarial = $request->empresarial == 1 ? 1 : null;

        $cad = new Planos();
        $cad->nome = $nome;
        $cad->empresarial = $empresarial;
        if($cad->save()) {
            $planos = Planos::select('nome','id')->get();
            return $planos;
        } else {
            return "error";
        }
    }

    public function corretoraStoreadministradora(Request $request)
    {
        
        if($request->ajax()) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            //$filename = time().'_'.$file->getClientOriginalName();
            
            $filename = uniqid().".".$extension;
            $location = 'administradoras';
            $uploadedFile = $file->move($location, $filename);
            $logo = $location.'/'.$filename;
            $cad = new Administradoras();
            $cad->nome = $request->nome;
            $cad->logo = $logo;
            if(!$cad->save()) {
                return "error";    
            } else {
                $admin = Administradoras::select("nome","id")->get();
                return $admin;
            }
            
        }
    }

    public function corretoraDeletarAdministradora(Request $request)
    {
        $admin = Administradoras::where("id",$request->id)->first();
        if($admin->logo && file_exists($admin->logo)) {
            unlink($admin->logo);
        }
        if(!$admin->delete()) {
            return "error";
        } 
        return "deletado";
    }




    public function corretoresDeletarPlanos(Request $request)
    {
        $id = $request->id;
        $plano = Planos::find($id);
        $plano->delete();

    }



    public function cadastrarPlanosHap(Request $request)
    {
        
        if($request->tipo == 1) {
            $dados = ComissoesCorretoresDefault::where("plano_id",$request->tipo_plano)->where("administradora_id",4)->where("tabela_origens_id",$request->cidade);
            if($dados->count() >= 1) {
                foreach($request->parcelas as $k => $v) {
                    $alt = ComissoesCorretoresDefault::where("plano_id",$request->tipo_plano)->where("administradora_id",4)->where("parcela",$k+1)->first();
                    $alt->valor = $v;
                    if(!$alt->save()) {
                        return "error";
                    }
                }
            } else {
                foreach($request->parcelas as $k => $v) {
                    $ca = new ComissoesCorretoresDefault();
                    $ca->plano_id = $request->tipo_plano;
                    $ca->administradora_id = 4;
                    $ca->tabela_origens_id = $request->cidade;
                    $ca->parcela = $k + 1;
                    $ca->valor = $v;
                    if(!$ca->save()) {
                        return "error";
                    }
                }
            }
            return "cadastrado";
        } else if($request->tipo == 2) {

            $dados = ComissoesCorretoresParceiros::where("plano_id",$request->tipo_plano)->where("administradora_id",4)->where("tabela_origens_id",$request->cidade);
            if($dados->count() >= 1) {
                foreach($request->parcelas as $k => $v) {
                    $alt = ComissoesCorretoresParceiros::where("plano_id",$request->tipo_plano)->where("administradora_id",4)->where("parcela",$k+1)->first();
                    $alt->valor = $v;
                    if(!$alt->save()) {
                        return "error";
                    }
                }
            } else {
                foreach($request->parcelas as $k => $v) {
                    $ca = new ComissoesCorretoresParceiros();
                    $ca->plano_id = $request->tipo_plano;
                    $ca->administradora_id = 4;
                    $ca->tabela_origens_id = $request->cidade;
                    $ca->parcela = $k + 1;
                    $ca->valor = $v;
                    if(!$ca->save()) {
                        return "error";
                    }
                }
            }
            return "cadastrado";
        } else {
            $dados = ComissoesCorretoresPersonalizados
                ::where("plano_id",$request->tipo_plano)
                ->where("administradora_id",4)
                ->where("tabela_origens_id",$request->cidade)
                ->where("user_id",$request->user);
                if($dados->count() >= 1) {

                    foreach($request->parcelas as $k => $v) {
                        $alt = ComissoesCorretoresPersonalizados
                            ::where("plano_id",$request->tipo_plano)
                            ->where("administradora_id",4)
                            ->where("user_id",$request->user)
                            ->where("parcela",$k+1)->first();
                        $alt->valor = $v;
                        if(!$alt->save()) {
                            return "error";
                        }
                    }
                } else {

                    foreach($request->parcelas as $k => $v) {
                        $ca = new ComissoesCorretoresPersonalizados();
                        $ca->plano_id = $request->tipo_plano;
                        $ca->administradora_id = 4;
                        $ca->tabela_origens_id = $request->cidade;
                        $ca->user_id = $request->user;
                        $ca->parcela = $k + 1;
                        $ca->valor = $v;
                        if(!$ca->save()) {
                            return "error";
                        }
                    }
                    return "cadastrado";
                }
        }
    }

    public function corretoraValorCorretorComissao(Request $request)
    {
        $id         = $request->id;
        $tipo       = $request->tipo;
        $valor      = $request->valor;
        if($tipo == 1) {
            $alt = ComissoesCorretoresDefault::find($id);
            $alt->valor = str_replace([".",","],["","."],$valor);
            $alt->save();
        } elseif($tipo == 2) {
            $alt = ComissoesCorretoresParceiros::find($id);
            $alt->valor = str_replace([".",","],["","."],$valor);
            $alt->save();
        } else {
            $alt = ComissoesCorretoresPersonalizados::find($id);
            $alt->valor = str_replace([".",","],["","."],$valor);
            $alt->save();
        }             
    }


    public function corretoraExcluirComissaoCorretor(Request $request)
    {
        
        $tipo = $request->tipo;
        if($tipo == 1) {
            ComissoesCorretoresDefault::where('plano_id',$request->plano)->where('administradora_id',$request->administradora)->delete();
            $quantidade = ComissoesCorretoresDefault::count();
            return $quantidade;
        } else {
            ComissoesCorretoresParceiros::where('plano_id',$request->plano)->where('administradora_id',$request->administradora)->delete();
            $quantidade = ComissoesCorretoresParceiros::count();
            return $quantidade;
        }
        
    }




    public function showAlterarCorretor(Request $request)
    {   
        $user = "";  
        $tipo = $request->id;
        if($tipo == 1) {
            $configuracoes = ComissoesCorretoresDefault
                ::with(['planos','administradoras'])->get();
        } elseif($tipo == 2) {
            $configuracoes = ComissoesCorretoresParceiros
                ::with(['planos','administradoras'])->get();
        } else {
            $user = User::find($request->user)->name;
            $configuracoes = ComissoesCorretoresPersonalizados
            ::where("user_id",$request->user)
            ->with(['planos','administradoras'])
            ->get();
        }
        

        if(count($configuracoes) >= 1) {

            $plano_inicial      = $configuracoes[0]->plano_id;
            $administradora_id  = $configuracoes[0]->administradora_id;
            

            return view('admin.pages.home.alterar-corretor',[
                "tipo" => $tipo,
                "user" => $user,
                "dados" => $configuracoes,
                "plano_inicial" => $plano_inicial,
                "administradora_id" => $administradora_id
            ]);

        } else {
            return "empty";
        }
    }

    public function storeCorretora(Request $request)
    {
        $cidade = $request->input('cidade');
        $dados = $request->input('dados');
        $dadosParaInserir = [];
        foreach ($dados as $chave => $valores) {
            $chaveParts = explode('_', $chave);
            $isColetivo = Str::contains($chave, 'coletivo');
            $administradora_id = (int) $isColetivo ? end($chaveParts) : 4;
            $plano_id = (int) $isColetivo ? 3 : end($chaveParts);
            $tabela_origens_id = $cidade;
            foreach ($valores as $parcela => $valor) {
                $dadosParaInserir[] = [
                    'plano_id' => $plano_id,
                    'administradora_id' => $administradora_id,
                    'tabela_origens_id' => $cidade,
                    'valor' => $valor,
                    'parcela' => $parcela,
                ];
            }
        }
        foreach($dadosParaInserir as $d) {
            $alt = ComissoesCorretoraConfiguracoes::where('plano_id',$d['plano_id'])
                ->where('administradora_id',$d['administradora_id'])
                ->where('tabela_origens_id',$d['tabela_origens_id'])
                ->where('parcela',$d['parcela']);
            if($alt->count() >= 1) {
                $cidade_corretora = ComissoesCorretoraConfiguracoes::select('tabela_origens.nome','tabela_origens.id')
                ->join('tabela_origens', 'comissoes_corretora_configuracoes.tabela_origens_id', '=', 'tabela_origens.id')
                ->groupBy('comissoes_corretora_configuracoes.tabela_origens_id')
                ->get();
                return [
                    "resposta" => 'ja_existe',
                    'cidade_corretora' => $cidade_corretora
                ];
            }   
            $cad = new ComissoesCorretoraConfiguracoes();
            $cad->plano_id = $d['plano_id'];
            $cad->administradora_id = $d['administradora_id'];
            $cad->tabela_origens_id = $cidade;
            $cad->valor = $d['valor'];
            $cad->parcela = $d['parcela'];
            if(!$cad->save()) return "error";           
        }
        $cidade_corretora = ComissoesCorretoraConfiguracoes::select('tabela_origens.nome','tabela_origens.id')
        ->join('tabela_origens', 'comissoes_corretora_configuracoes.tabela_origens_id', '=', 'tabela_origens.id')
        ->groupBy('comissoes_corretora_configuracoes.tabela_origens_id')
        ->get();
        return $cidade_corretora;
    }

    public function corretoraCriarTabelasCadastroDinamicamente(Request $request)
    {
        //return $request->plano;
        $administradoras = Administradoras::where('nome',"!=","Hapvida")->get();
        $planos = explode(",",$request->plano);

        // $planos_transformado = array_map(function($item) {
        //     return str_replace(' ', '_', strtolower($item));
        // }, $planos);
        $planosIds = Planos::whereIn('id', $planos)->pluck('id')->toArray();
        $planoNome = Planos::whereIn('id', $planos)->pluck('nome')->toArray();

        

        // $planosIds = Planos::where(function ($query) use ($planos) {
        //     foreach ($planos as $plano) {
        //         $query->orWhere('nome', 'like', '%' . $plano . '%');
        //     }
        // })->toSql();

        


        $existe = ComissoesCorretoraConfiguracoes::count();
        $mostrar = true;
        if($existe >= 1) {
             $mostrar = false;
        }
        $plano3Presente = in_array(3, $planosIds);
        if($plano3Presente) {
            foreach($administradoras as $admin) {
                for ($parcela = 1; $parcela <= 7; $parcela++) {       
                    $cad = new ComissoesCorretoraConfiguracoes();
                    $cad->plano_id = 3;
                    $cad->administradora_id = $admin->id;
                    $cad->tabela_origens_id = 2;
                    $cad->valor = 0;
                    $cad->parcela = $parcela;
                    if(!$cad->save()) {
                        return "error";
                    }
                }
            }
        }
        $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
        if(count($planosNew) >= 1) {
            foreach($planosNew as $plano) {
                for($bb=1;$bb<=6;$bb++) {
                    $cad = new ComissoesCorretoraConfiguracoes();
                    $cad->plano_id = $plano;
                    $cad->administradora_id = 4;
                    $cad->tabela_origens_id = 2;
                    $cad->valor = 0;
                    $cad->parcela = $bb;
                    if(!$cad->save()) {
                        return "error";
                    }
                }
            }
        }
        $planoIdMap = [];
        foreach ($planosIds as $plano) {
            $planoModel = Planos::find($plano);
            if ($planoModel) {
                $planoIdMap[$planoModel->nome] = $planoModel->id;
            }
        }
        
        
        
        $configuracoes = ComissoesCorretoraConfiguracoes::whereIn('plano_id', $planosIds);        
        return [
            'view' => view('admin.pages.home.tabela-dinamica',[
                "administradoras" => $administradoras,
                "planos" => $planoNome,
                "mostrar" => $mostrar,
                "configuracoes" => $configuracoes->get(),
                "planoIdMap" => $planoIdMap,
                      
            ])->render(),
            "planos" => $planoNome
        ];

    }



    public function plusCorretor(Request $request)
    {
        return $request->all();
    }


    public function storeCorretor(Request $request)
    {
        $tipo = "";
        $user = "";
        $administradoras = Administradoras::where('nome',"!=","Hapvida")->get();
        $planos = $request->planos;
        
        $planoIdMap = [];
        foreach ($planos as $plano) {
            $planoModel = Planos::where('nome', $plano)->first();
            if ($planoModel) {
                $planoIdMap[$plano] = $planoModel->id;
            }
        }
        
        $planosIds = Planos::whereIn('nome', $planos)->pluck('id')->toArray();     
        if($request->tipo == 1) {      
            $tipo = 1;      
            $configuracoes = ComissoesCorretoresDefault::whereIn("plano_id",$planosIds);
            if($configuracoes->count() == 0) {
                $plano3Presente = in_array(3, $planosIds);
                if($plano3Presente) {
                    foreach($administradoras as $admin) {
                        for ($parcela = 1; $parcela <= 7; $parcela++) {       
                            $cad = new ComissoesCorretoresDefault();
                            $cad->plano_id = 3;
                            $cad->administradora_id = $admin->id;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $parcela;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }

                $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
                if(count($planosNew) >= 1) {
                    foreach($planosNew as $plano) {
                        for($bb=1;$bb<=6;$bb++) {
                            $cad = new ComissoesCorretoresDefault();
                            $cad->plano_id = $plano;
                            $cad->administradora_id = 4;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $bb;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }
            } 




        } else if($request->tipo == 2) {
            
            $tipo = 2;
            $configuracoes = ComissoesCorretoresParceiros::whereIn("plano_id",$planosIds);
            if($configuracoes->count() == 0) {
                $plano3Presente = in_array(3, $planosIds);
                if($plano3Presente) {
                    foreach($administradoras as $admin) {
                        for ($parcela = 1; $parcela <= 7; $parcela++) {       
                            $cad = new ComissoesCorretoresParceiros();
                            $cad->plano_id = 3;
                            $cad->administradora_id = $admin->id;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $parcela;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }

                $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
                if(count($planosNew) >= 1) {
                    foreach($planosNew as $plano) {
                        for($bb=1;$bb<=6;$bb++) {
                            $cad = new ComissoesCorretoresParceiros();
                            $cad->plano_id = $plano;
                            $cad->administradora_id = 4;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $bb;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }
            } 
        } else {
            $user = User::find($request->user)->name;
            $planosIds = Planos::whereIn('nome', $planos)->pluck('id')->toArray();
            $plano3Presente = in_array(3,$planosIds);
            $configuracoes = ComissoesCorretoresPersonalizados::whereIn("plano_id",$planosIds)->where("user_id",$request->user);
            if($plano3Presente) {
                foreach($administradoras as $admin) {
                    for ($parcela = 1; $parcela <= 7; $parcela++) {       
                        $cad = new ComissoesCorretoresPersonalizados();
                        $cad->plano_id = 3;
                        $cad->user_id = $request->user;
                        $cad->administradora_id = $admin->id;
                        $cad->valor = 0;
                        $cad->parcela = $parcela;
                        if(!$cad->save()) {
                            return "error";
                        }
                    }
                }
            }
            
            $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
                if(count($planosNew) >= 1) {
                    foreach($planosNew as $plano) {
                        for($bb=1;$bb<=6;$bb++) {
                            $cad = new ComissoesCorretoresPersonalizados();
                            $cad->plano_id = $plano;
                            $cad->administradora_id = 4;
                            $cad->user_id = $request->user;
                            $cad->valor = 0;
                            $cad->parcela = $bb;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }

        }
        
        return [
            "view" => view('admin.pages.home.tabela-dinamica-corretor',[
                "administradoras" => $administradoras,
                "planos" => $planos,
                "configuracoes" => $configuracoes->get(),
                "planoIdMap" => $planoIdMap,
                "tipo" => $tipo,
                "user" => $user
            ])->render(),
        ];



        
    }





    public function alterarCorretor(Request $request) 
    {
        $dados = $request->dados;
        $tipo = $request->tipo;
        if($tipo == 1) {

            foreach ($dados as $chave => $valores) {
                $chaveParts = explode('_',$chave);
                $administradora_id = $chaveParts[1];
                $plano_id = $chaveParts[3];
                $tabela_origens_id = $chaveParts[2];
                
                foreach($valores as $parcela => $valor) {
                    $alt = ComissoesCorretoresDefault
                    ::where('plano_id',$plano_id)
                    ->where('administradora_id',$administradora_id)
                    ->where('tabela_origens_id',$tabela_origens_id)
                    ->where("parcela",$parcela)
                    ->first();
                    $alt->valor = $valor;
                    if(!$alt->save()) return "error";
                }
            }


        } else {

            foreach ($dados as $chave => $valores) {
                $chaveParts = explode('_',$chave);
                $administradora_id = $chaveParts[1];
                $plano_id = $chaveParts[3];
                $tabela_origens_id = $chaveParts[2];
                
                foreach($valores as $parcela => $valor) {
                    $alt = ComissoesCorretoresParceiros
                    ::where('plano_id',$plano_id)
                    ->where('administradora_id',$administradora_id)
                    ->where('tabela_origens_id',$tabela_origens_id)
                    ->where("parcela",$parcela)
                    ->first();
                    $alt->valor = $valor;
                    if(!$alt->save()) return "error";
                }
            }
        }
        return "alterado";
    }







    public function alterarCorretora(Request $request)
    {
        $cidade = $request->input('cidade');
        $dados = $request->input('dados');
        foreach ($dados as $chave => $valores) {
            $chaveParts = explode('_',$chave);
            $administradora_id = $chaveParts[3];
            $plano_id = $chaveParts[2];
            $tabela_origens_id = $cidade;
            foreach($valores as $parcela => $valor) {
                $alt = ComissoesCorretoraConfiguracoes
                ::where('plano_id',$plano_id)
                ->where('administradora_id',$administradora_id)
                ->where('tabela_origens_id',$tabela_origens_id)
                ->where("parcela",$parcela)
                ->first();
                $alt->valor = $valor;
                if(!$alt->save()) return "error";

            }
        }
        return "cadastrar";
    }

    public function cadastrarCorretorComissao(Request $request)
    {
        
        $dados = $request->input('dados');

        $cidade = $request->input('cidade');

        foreach($dados as $chave => $valores) {
            $chaveParts = explode('_', $chave);
            $isColetivo = Str::contains($chave, 'coletivo');
            $administradora_id = (int) $isColetivo ? end($chaveParts) : 4;
            $plano_id = (int) $isColetivo ? 3 : end($chaveParts);
            $tabela_origens_id = $cidade;

            foreach ($valores as $parcela => $valor) {
                $dadosParaInserir[] = [
                    'plano_id' => $plano_id,
                    'administradora_id' => $administradora_id,
                    'tabela_origens_id' => $tabela_origens_id,
                    'valor' => $valor,
                    'parcela' => $parcela,
                ];
            }

        }


        



        foreach($dadosParaInserir as $d) {
            if($request->tipo == 1) {
                $alt = ComissoesCorretoresDefault::where('plano_id',$d['plano_id'])
                    ->where('administradora_id',$d['administradora_id'])
                    ->where('tabela_origens_id',$d['tabela_origens_id'])
                    ->where('parcela',$d['parcela']);
                    
                 if($alt->count() >= 1) return;   

                $cad = new ComissoesCorretoresDefault();
                $cad->plano_id = $d['plano_id'];
                $cad->administradora_id = $d['administradora_id'];
                $cad->tabela_origens_id = $d['tabela_origens_id'];
                $cad->valor = $d['valor'];
                $cad->parcela = $d['parcela'];
                if(!$cad->save()) return "error";


            } else {

                $alt = ComissoesCorretoresParceiros::where('plano_id',$d['plano_id'])
                    ->where('administradora_id',$d['administradora_id'])
                    ->where('tabela_origens_id',$d['tabela_origens_id'])
                    ->where('parcela',$d['parcela']);

                    
                if($alt->count() >= 1) return;

                $cad = new ComissoesCorretoresParceiros();
                $cad->plano_id = $d['plano_id'];
                $cad->administradora_id = $d['administradora_id'];
                $cad->tabela_origens_id = $d['tabela_origens_id'];
                $cad->valor = $d['valor'];
                $cad->parcela = $d['parcela'];
                if(!$cad->save()) return "error";



            }
            
            
            
            
            
            
        }

        return "cadastrado";

    }


    


    public function corretoraVerificarComissao(Request $request)
    {
        $cidade = $request->cidade;
        $tipo_plano = $request->tipo_plano;
        $administradora = $request->administradora;

        if($tipo_plano == 3) {
            
            $dados = ComissoesCorretoraConfiguracoes::where("plano_id",3)->where("administradora_id",$administradora)->where("tabela_origens_id",$cidade);
            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }

        } else {

            $dados = ComissoesCorretoraConfiguracoes
                ::where("plano_id",$request->plano)
                ->where("administradora_id",4)
                ->where("tabela_origens_id",$request->cidade);
            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }

        }






        
    }










    public function verificarComissaoTrocarCidade(Request $request)
    {
        if($request->administradora == 1 || $request->administradora == null) {
            $administradora = 4;
        } else {
            $administradora = $request->administradora;
        }

        if($request->tipo == 1) {
            $dados = ComissoesCorretoresDefault
                ::where("plano_id",$request->plano)
                ->where("administradora_id",$administradora)
                ->where("tabela_origens_id",$request->cidade);
            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }
        } else if($request->tipo == 3) {

            $dados = ComissoesCorretoresPersonalizados
                ::where("plano_id",$request->plano)
                ->where("administradora_id",$administradora)
                ->where("tabela_origens_id",$request->cidade)
                ->where("user_id",$request->user);
            
            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }    



        } 










    }


    public function cadastrarComissaoCorretorColetivo(Request $request)
    {

        

        if($request->tipo == 1) {
            
            $dados = ComissoesCorretoresDefault::where("plano_id",$request->plano)->where("administradora_id",$request->administradora);
            if($dados->count() >= 1) {
                foreach($request->parcelas as $k => $v) {
                    $alt = ComissoesCorretoresDefault::where("plano_id",$request->plano)->where("administradora_id",$request->administradora)->where("parcela",$k+1)->first();
                    $alt->valor = $v;
                    if(!$alt->save()) {
                        return "error";
                    }
                }
            } else {
                foreach($request->parcelas as $k => $p) {
                    $pp = new ComissoesCorretoresDefault();
                    $pp->plano_id = $request->plano;
                    $pp->administradora_id = $request->administradora;
                    $pp->tabela_origens_id = $request->cidade;
                    $pp->valor = $p;
                    $pp->parcela = $k + 1;
                    if(!$pp->save()) {
                        return "error";
                    }
                }
            }

        } else if($request->tipo == 2) {

            $dados = ComissoesCorretoresParceiros::where("plano_id",$request->plano)->where("administradora_id",$request->administradora);  

            if($dados->count() >= 1) {

                foreach($request->parcelas as $k => $v) {
                    $alt = ComissoesCorretoresParceiros::where("plano_id",$request->plano)->where("administradora_id",$request->administradora)->where("parcela",$k+1)->first();
                    $alt->valor = $v;
                    if(!$alt->save()) {
                        return "error";
                    }
                }

            } else {
                
                foreach($request->parcelas as $k => $p) {
                    $pp = new ComissoesCorretoresParceiros();
                    $pp->plano_id = $request->plano;
                    $pp->administradora_id = $request->administradora;
                    $pp->tabela_origens_id = $request->cidade;
                    $pp->valor = $p;
                    $pp->parcela = $k + 1;
                    if(!$pp->save()) {
                        return "error";
                    }
                }

            }

        } else {

            $dados = ComissoesCorretoresPersonalizados
                ::where("plano_id",$request->plano)
                ->where("administradora_id",$request->administradora)
                ->where('tabela_origens_id',$request->cidade)
                ->where('user_id',$request->user);

            if($dados->count() >= 1) {
                
                foreach($request->parcelas as $k => $v) {
                    $alt = ComissoesCorretoresPersonalizados
                        ::where("plano_id",$request->plano)
                        ->where("administradora_id",$request->administradora)
                        ->where("tabela_origens_id",$request->cidade)
                        ->where("user_id",$request->user)
                        ->where("parcela",$k+1)
                        ->first();

                    $alt->valor = $v;
                    if(!$alt->save()) {
                        return "error";
                    }
                }






            } else {


                foreach($request->parcelas as $k => $p) {
                    $cad = new ComissoesCorretoresPersonalizados();
                    $cad->administradora_id = $request->administradora;
                    $cad->plano_id = $request->plano;
                    $cad->tabela_origens_id = $request->cidade;
                    $cad->user_id = $request->user;
                    $cad->valor = $p;
                    $cad->parcela = $k + 1;
                    if(!$cad->save()) {
                        return "error";
                    }
                }




                
            }    






        }

        
        return "cadastrado";
    }

    public function verificarParcelasColetivo(Request $request)
    {

        $tipo = $request->tipo;

        if($tipo == 1) {//Default

            $dados = ComissoesCorretoresDefault
                ::where("plano_id",$request->plano)
                ->where("administradora_id",$request->administradora)
                ->where("tabela_origens_id",$request->cidade);

            if($dados->count() >= 1) {
                return $dados->get();
            } else {
                return null;
            }

        } else {

        }


    }




    public function store(Request $request)
    {
        $corretora = Corretora::first();
        $corretora->cnpj = $request->cnpj;
        $corretora->razao_social = $request->razao_social;
        $corretora->celular = $request->celular;
        $corretora->telefone = $request->telefone;
        $corretora->email = $request->email;
        $corretora->cep = $request->cep;
        $corretora->cidade = $request->cidade;
        $corretora->uf = $request->uf;
        $corretora->bairro = $request->bairro;
        $corretora->rua = $request->rua;
        $corretora->complemento = $request->complemento;
        $corretora->site = $request->site;
        $corretora->instagram = $request->instagram;
        $corretora->facebook = $request->facebook;
        $corretora->linkedin = $request->linkedin;
        if($corretora->save()) {
            return Corretora::first();
        } else {
            return "error";
        }
    }

    public function corretoraJaExisteCriarTabelasCadastroDinamicamente(Request $request)
    {
        




        $administradoras = Administradoras::where('nome',"!=","Hapvida")->get();
        $planos = explode(",",$request->plano);
        
        $cidade = TabelaOrigens::find($request->cidade)->nome;
        
        $cidade_id = $request->cidade;    
        $planos_transformado = array_map(function($item) {
            return str_replace(' ', '_', strtolower($item));
        }, $planos);
        $planosIds = Planos::whereIn('nome', $planos)->pluck('id')->toArray();
        $plano3Presente = in_array(3, $planosIds);
        if($plano3Presente) {
            foreach($administradoras as $admin) {
                for ($parcela = 1; $parcela <= 7; $parcela++) {       
                    $cad = new ComissoesCorretoraConfiguracoes();
                    $cad->plano_id = 3;
                    $cad->administradora_id = $admin->id;
                    $cad->tabela_origens_id = $cidade_id;
                    $cad->valor = 0;
                    $cad->parcela = $parcela;
                    if(!$cad->save()) {
                        return "error";
                    }
                }
            }
        }
        $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
        if(count($planosNew) >= 1) {
            foreach($planosNew as $plano) {
                for($bb=1;$bb<=6;$bb++) {
                    $cad = new ComissoesCorretoraConfiguracoes();
                    $cad->plano_id = $plano;
                    $cad->administradora_id = 4;
                    $cad->tabela_origens_id = $cidade_id;
                    $cad->valor = 0;
                    $cad->parcela = $bb;
                    if(!$cad->save()) {
                        return "error";
                    }
                }
            }
        }
        $configuracoes = ComissoesCorretoraConfiguracoes::whereIn('plano_id', $planosIds)
        ->where('tabela_origens_id', $cidade_id)
        ->get();
       

        


        $planoIdMap = [];
        foreach ($planos as $plano) {
            // Consulte o banco de dados para obter o plano_id com base no nome do plano
            $planoModel = Planos::where('nome', $plano)->first();
            if ($planoModel) {
                $planoIdMap[$plano] = $planoModel->id;
            }
        }   
        
        return [
            'view' => view('admin.pages.home.tabela-dinamica-existe',[
                "administradoras" => $administradoras,
                "planos" => $planos,
                "cidade" => $cidade,
                "configuracoes" => $configuracoes,
                "planoIdMap" => $planoIdMap
                       
            ])->render(),
            
        ];



    }


    public function corretoraPlanosComissaoCorretor(Request $request)
    {
        if($request->tipo == 1) {
            $planos = Planos::whereNotIn('id', function ($query) use($request) {
                $query->select('plano_id')
                    ->from('comissoes_corretores_default');
                    //->where('tabela_origens_id', $request->cidade);
            })->select("id","nome")->get();
    
            return $planos;
        } else if($request->tipo == 2) {
            $planos = Planos::whereNotIn('id', function ($query) use($request) {
                $query->select('plano_id')
                    ->from('comissoes_corretores_parceiros');
                    //->where('tabela_origens_id', $request->cidade);
            })->select("id","nome")->get();
    
            return $planos;
        } else {

            $planos = Planos::whereNotIn('id', function ($query) use($request) {
                $query->select('plano_id')
                    ->from('comissoes_corretores_personalizado')
                    ->where('user_id', $request->user);
            })->select("id","nome")->get();
    
            return $planos;







        }
        
    }


    public function corretoraPlusAllPlanosAlterar(Request $request)
    {
       
        $tipo = $request->tipo;
        $planos = $request->planos;
        $administradoras = Administradoras::where('nome',"!=","Hapvida")->get();
        $planosIds = Planos::whereIn('nome', $planos)->pluck('id')->toArray();
        
        

        if($tipo == 1) {


            $plano3Presente = in_array(3, $planosIds);
                if($plano3Presente) {
                    foreach($administradoras as $admin) {
                        for ($parcela = 1; $parcela <= 7; $parcela++) {       
                            $cad = new ComissoesCorretoresDefault();
                            $cad->plano_id = 3;
                            $cad->administradora_id = $admin->id;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $parcela;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }

                $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
                if(count($planosNew) >= 1) {
                    foreach($planosNew as $plano) {
                        for($bb=1;$bb<=6;$bb++) {
                            $cad = new ComissoesCorretoresDefault();
                            $cad->plano_id = $plano;
                            $cad->administradora_id = 4;
                            $cad->tabela_origens_id = 2;
                            $cad->valor = 0;
                            $cad->parcela = $bb;
                            if(!$cad->save()) {
                                return "error";
                            }
                        }
                    }
                }
            


                $configuracoes = ComissoesCorretoresDefault
                ::with(['planos','administradoras'])->get();

                $plano_inicial      = $configuracoes[0]->plano_id;
                $administradora_id  = $configuracoes[0]->administradora_id;
                //$tabela_origens_id  = $configuracoes[0]->tabela_origens_id;
    
                return view('admin.pages.home.alterar-corretor',[
                    "tipo" => $tipo,
                    "dados" => $configuracoes,
                    "plano_inicial" => $plano_inicial,
                    "administradora_id" => $administradora_id
                    //"tabela_origens_id" => $tabela_origens_id
                ]);				











        } else {

            
            $plano3Presente = in_array(3, $planosIds);
            if($plano3Presente) {
                foreach($administradoras as $admin) {
                    for ($parcela = 1; $parcela <= 7; $parcela++) {       
                        $cad = new ComissoesCorretoresParceiros();
                        $cad->plano_id = 3;
                        $cad->administradora_id = $admin->id;
                        $cad->tabela_origens_id = 2;
                        $cad->valor = 0;
                        $cad->parcela = $parcela;
                        if(!$cad->save()) {
                            return "error";
                        }
                    }
                }
            }

            $planosNew = array_filter($planosIds, function ($valor) {return $valor !== 3;});
            if(count($planosNew) >= 1) {
                foreach($planosNew as $plano) {
                    for($bb=1;$bb<=6;$bb++) {
                        $cad = new ComissoesCorretoresParceiros();
                        $cad->plano_id = $plano;
                        $cad->administradora_id = 4;
                        $cad->tabela_origens_id = 2;
                        $cad->valor = 0;
                        $cad->parcela = $bb;
                        if(!$cad->save()) {
                            return "error";
                        }
                    }
                }
            }

            $configuracoes = ComissoesCorretoresParceiros
                ::with(['planos','administradoras','cidades'])->get();

            $plano_inicial      = $configuracoes[0]->plano_id;
            $administradora_id  = $configuracoes[0]->administradora_id;
            $tabela_origens_id  = $configuracoes[0]->tabela_origens_id;

            return view('admin.pages.home.alterar-corretor',[
                "tipo" => $tipo,
                "dados" => $configuracoes,
                "plano_inicial" => $plano_inicial,
                "administradora_id" => $administradora_id,
                "tabela_origens_id" => $tabela_origens_id
            ]);				



        }
    }




    

    public function corretoraPegarCidadeCorretorePlanos(Request $request) 
    {
        
        $planos = Planos::whereNotIn('id', function ($query) use($request) {
            $query->select('plano_id')
                ->from('comissoes_corretora_configuracoes');
                
        })->select("id","nome")->get();

        return $planos;


    }

    public function mudarValorTabela(Request $request)
    {
        $ta = Tabela::find($request->id);
        $ta->valor = str_replace([".",","],["","."],$request->valor);
        $ta->save();
    }

    public function administradoraPlanosCadastrar(Request $request)
    {
        
        $planos = explode(",",$request->planos);
        $administradora = $request->administradora;
        if(count($planos) >= 1) {
            foreach($planos as $p) {
                $adminPlanos = new AdministradoraPlanos();
                $adminPlanos->administradora_id = $administradora;
                $adminPlanos->plano_id = $p;
                if(!$adminPlanos->save()) {
                    return "error";
                }
            }
        }
        return "sucesso";
    }

    public function administradoraPlanosVerificar(Request $request)
    {
        $administradora = $request->administradora;
        $dados = AdministradoraPlanos::where("administradora_id",$administradora);
        if($dados->count() >= 1) {
            return $dados->pluck('plano_id')->unique();
        } else {
            return "nada";
        }
    }

    public function planosAdministradoraSelect(Request $request)
    {
        $administradora = $request->administradora;
        $dados = AdministradoraPlanos::where("administradora_id",$administradora);
        if($dados->count() >= 1) {
            $ids = $dados->pluck('plano_id')->unique();
            $planos = Planos::whereIn("id",$ids)->select('id','nome')->get();
            return $planos;
        } else {
            return "nada";
        }
    }





    public function removeComissaoCorretoraConfiguracoes(Request $request)
    {
        
        

        if($request->tipo == "hapvida") {
            $del = ComissoesCorretoraConfiguracoes::where("administradora_id",4)->where('plano_id',$request->plano);
            $del->delete();
        } else {
            $del = ComissoesCorretoraConfiguracoes::where("administradora_id",$request->administradora)->where('plano_id',3);
            $del->delete();
        }

        $quantidade = ComissoesCorretoraConfiguracoes::count();
        if($quantidade == 0) {
            return [
                "error" => "vazio"
            ];
        }


    }






    public function mudarValorComissaoEspecifica(Request $request)
    {
        $id = $request->id;
        $valor = $request->valor;

        $alt = ComissoesCorretoraConfiguracoes::find($id);
        $alt->valor = $valor;
        $alt->save();



    }





    public function corretoraVerificarCorretoraCidades(Request $request)
    {
        if($request->tipo_plano == 3) {
            $dados = ComissoesCorretoraConfiguracoes
                ::where("plano_id",3)
                ->where("administradora_id",$request->admnistradora_coletivo)
                ->where("tabela_origens_id",$request->cidade_id);

            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }





        } else {

            
            $dados = ComissoesCorretoraConfiguracoes
                ::where("plano_id",$request->plano_individual)
                ->where("administradora_id",4)
                ->where("tabela_origens_id",$request->cidade_id);

            if($dados->count() >= 1) {
                return $dados->select('valor')->get();
            } else {
                return "nada";
            }





        }
    }    







    public function storePdf(Request $request)
    {

        $corretora = Corretora::first();

        $corretora->consultas_eletivas_coletivo = $request->consulta_eletivas_coletivo;
        $corretora->consultas_urgencia_coletivo = $request->consulta_urgencia_coletivo;
        $corretora->exames_simples_coletivo = $request->exame_simples_coletivo;
        $corretora->exames_complexos_coletivo = $request->exames_complexos_coletivo;

        $corretora->terapias_coletivo = $request->terapias_coletivo;

        $corretora->consultas_eletivas_individual = $request->consulta_eletivas_individual;
        $corretora->consultas_urgencia_individual = $request->consulta_urgencia_individual;
        $corretora->exames_simples_individual = $request->exames_simples_individual;
        $corretora->exames_complexos_individual = $request->exames_complexos_individual;

        $corretora->terapias_individual = $request->terapias_individual;

        $corretora->linha_01_individual = $request->linha1_individual;
        $corretora->linha_02_individual = $request->linha2_individual;
        $corretora->linha_03_individual = $request->linha3_individual;

        $corretora->linha_01_coletivo = $request->linha1_coletivo;
        $corretora->linha_02_coletivo = $request->linha2_coletivo;
        $corretora->linha_03_coletivo = $request->linha3_coletivo;

        $corretora->save();
    }



}
