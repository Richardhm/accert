<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planos;
use App\Models\Administradoras;
use App\Models\Acomodacao;
use App\Models\FaixaEtaria;
use App\Models\TabelaOrigens;
use App\Models\Tabela;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ConfigurarCoparticipacao;

class TabelaController extends Controller
{
    public function index()
    {
        $administradoras = Administradoras::all();
        $planos = Planos::all();
        $acomodacao = Acomodacao::all();
        $faixas = FaixaEtaria::all();

        $tabela_origem = TabelaOrigens::all();

        return view('admin.pages.tabelas.index',[
            "administradoras" => $administradoras,
            "planos" => $planos,
            "acomodacao" => $acomodacao,
            "faixas" => $faixas,
            "tabela_origem" => $tabela_origem
        ]);
    }

    public function search()
    {

        $administradoras = Administradoras::all();
        $tipos = Planos::all();

        $modelos = Acomodacao::all();
        $cidades =  TabelaOrigens::all();



        return view('admin.pages.tabelas.search',[

            "administradoras" => $administradoras,
            "tipos" => $tipos,
            "modelos" => $modelos,
            "cidades" => $cidades
        ]);
    }

    public function pesquisar(Request $request)
    {

        $rules = [
            "administradora_search" => "required",
            "planos_search" => "required",
            "coparticipacao_search" => "required",
            "odonto_search" => "required",
            "cidade_search" => "required"
        ];

        $message = [
            "administradora_search.required" => "O campo administradora e campo obrigatorio",
            "planos_search.required" => "O campo plano e campo obrigatorio",
            "coparticipacao_search.required" => "O campo coparticipacao e campo obrigatorio",
            "odonto_search.required" => "O campo odonto e campo obrigatorio",
            "cidade_search.required" => "O campo cidade e campo obrigatorio"
        ];

        $request->validate($rules,$message);

        $administradora = $request->administradora_search;
        $planos = $request->planos_search;
        $coparticipacao = ($request->coparticipacao_search == "sim" ? 1 : 0);
        $odonto = ($request->odonto_search == "sim" ? 1 : 0);
        $cidade = $request->cidade_search;

        $tabelas = DB::select("SELECT faixas,apartamento,id_apartamento,enfermaria,id_enfermaria,ambulatorial,id_ambulatorial FROM (
                select
                    (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS faixas,
                    (SELECT valor FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS apartamento,
                    (SELECT id    FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS id_apartamento,

                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS enfermaria,
                    (SELECT id FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS id_enfermaria,
                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS ambulatorial,
                    (SELECT id FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id) AS id_ambulatorial


                    from tabelas AS fora
                    where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND tabela_origens_id = ".$cidade." GROUP BY faixa_etaria_id ORDER BY id) AS full_tabela");



        $administradoras = Administradoras::all();
        $tipos = Planos::all();
        $cidades =  TabelaOrigens::all();


        return view("admin.pages.tabelas.search",[
                "header" => "",
                "tabelas" => $tabelas,
                "cidades" => $cidades,
                "administradoras" => $administradoras,
                "tipos" => $tipos,


                "administradora_id" => $administradora ?? "",
                "plano_id" => !empty($planos) ? $planos : "",
                "cidade_id" => !empty($cidade) ? $cidade : "",
                "coparticipacao" => ($request->coparticipacao_search == "sim" ? 1 : 0),
                "odonto" => ($request->odonto_search == "sim" ? 1 : 0),
                "coparticipacao_texto" => ($request->coparticipacao_search == "sim" ? "Com Coparticipacao" : "Sem Coparticipacao"),
                "odonto_texto" => ($request->odonto_search == "sim" ? "Com Odonto" : "Sem Odonto"),
                "administradora_texto" => Administradoras::where("id",$request->administradora_search)->selectRaw("nome")->first()->nome
            ]);
    }





    protected function regraValidacaoUnicidade()
    {
        $odonto = $this->request->odonto == "sim" ? true : false;
        $coparticipacao = $this->request->coparticipacao == "sim" ? true : false;


        return Rule::unique('tabelas')
            ->where('administradora_id', $this->request->administradora)
            ->where('plano_id', $this->request->planos)
            ->where('tabela_origens_id', $this->request->tabela_origem)
            ->where('coparticipacao', $coparticipacao)
            ->where('odonto', $odonto);

    }


    /*Precisa verificar apenas os campos administradora_id,plano_id,tabela_origens_id,coparticipacao,odonto*/


    public function store(Request $request)
    {
       
       
        $ja_existe = Tabela
            ::where("administradora_id",$request->administradora)
            ->where("tabela_origens_id",$request->tabela_origem)
            ->where("plano_id",$request->planos)
            ->where("coparticipacao",$request->coparticipacao)
            ->where("odonto",$request->odonto);

        if($ja_existe->count() >= 1) {
            return redirect()->route('tabela.index')->with('error',"Já existe essa tabela cadastrada");
        }

        $regras = [
            'administradora' => 'required',
            'planos' => 'required',
            'tabela_origem' => 'required',
            'coparticipacao' => 'required',
            'odonto' => 'required',
            'faixa_etaria_id_apartamento' => 'required|array',
            'faixa_etaria_id_enfermaria' => 'required|array',
            'faixa_etaria_id_ambulatorial' => 'required|array',
            'valor_apartamento' => 'required|array',
            'valor_apartamento.*' => 'required', // Validação para cada valor do array
            'valor_enfermaria' => 'required|array',
            'valor_enfermaria.*' => 'required', // Validação para cada valor do array
            'valor_ambulatorial' => 'required|array',
            'valor_ambulatorial.*' => 'required', // Validação para cada valor do array
        ];

        // Mensagens de erro personalizadas
        $mensagens = [
            'required' => 'O campo :attribute é obrigatório.',
        ];

        // Executa a validação
        $request->validate($regras, $mensagens);

         foreach($request->faixa_etaria_id_apartamento as $k => $v) {
                $tabela = new Tabela();

                $tabela->administradora_id = $request->administradora;
                $tabela->plano_id = $request->planos;
                $tabela->tabela_origens_id = $request->tabela_origem;
                $tabela->acomodacao_id = 1;

                $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
                $tabela->odonto = ($request->odonto == "sim" ? true : false);
                $tabela->faixa_etaria_id = $request->faixa_etaria_id_apartamento[$k];
                $tabela->valor = str_replace([".",","],["","."],$request->valor_apartamento[$k]);
                $tabela->save();
            }

            foreach($request->faixa_etaria_id_enfermaria as $k => $v) {
                $tabela = new Tabela();

                $tabela->administradora_id = $request->administradora;
                $tabela->plano_id = $request->planos;
                $tabela->tabela_origens_id = $request->tabela_origem;
                $tabela->acomodacao_id = 2;

                $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
                $tabela->odonto = ($request->odonto == "sim" ? true : false);

                $tabela->faixa_etaria_id = $request->faixa_etaria_id_enfermaria[$k];
                $tabela->valor = str_replace([".",","],["","."],$request->valor_enfermaria[$k]);

                $tabela->save();
            }

            foreach($request->faixa_etaria_id_ambulatorial as $k => $v) {
                $tabela = new Tabela();

                $tabela->administradora_id = $request->administradora;
                $tabela->plano_id = $request->planos;
                $tabela->tabela_origens_id = $request->tabela_origem;
                $tabela->acomodacao_id = 3;

                $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
                $tabela->odonto = ($request->odonto == "sim" ? true : false);

                $tabela->faixa_etaria_id = $request->faixa_etaria_id_ambulatorial[$k];
                $tabela->valor = str_replace([".",","],["","."],$request->valor_ambulatorial[$k]);


                $tabela->save();
            }
            
            





            return redirect()->route('tabela.index')->with('success',"A tabela foi cadastrada com sucesso");
    }

    public function cadastrarValoresTabela(Request $request)
    {
        
        foreach($request->valoresApartamento as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 1;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);
            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresApartamento[$k]);

            if(!$tabela->save()) {
                return "error";
            }
        }

        foreach($request->valoresEnfermaria as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 2;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);

            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresEnfermaria[$k]);

            if(!$tabela->save()) {
                return "error";
            }
        }

        foreach($request->valoresAmbulatorial as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 3;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);

            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresAmbulatorial[$k]);


            if(!$tabela->save()) {
                return "error";
            }
        }

        return "sucesso";


    }









    public function edit(Request $request)
    {
        $id = $request->id;
        $alt = Tabela::where("id",$id)->first();
        $alt->valor = str_replace([".",","],["","."],$request->valor);
        if($alt->save()) {
            return "alterado";
        } else {
            return "error";
        }
    }

    public function verificarValoresTabela(Request $request) 
    {
        
        $administradora_id = $request->administradora;
        $plano_id = $request->planos;
        $tabela_origem_id = $request->tabela_origem;
        $coparticipacao = $request->coparticipacao == "sim" ? 1 : 0;
        $odonto = $request->odonto == "sim" ? 1 : 0;

        

        $tabela = Tabela::where("administradora_id",$administradora_id)
            ->where("tabela_origens_id",$tabela_origem_id)
            ->where("plano_id",$plano_id)
            ->where("coparticipacao",$coparticipacao)
            ->where("odonto",$odonto)
            ->select("acomodacao_id", "valor","id")
            ->get();
            
        if($tabela->count() >= 1) {
            $ta = $tabela->map(function ($item) {
                
                $item->valor_formatado = number_format($item->valor, 2, ',', '.');
                return $item;
            });
            return $ta;
        } else {
            return "empty";
        }
                    

    }

    public function verCoparticipacao(Request $request)
    {
        $plano = $request->plano;
        $cidade = $request->cidade;
        //return $plano."-".$cidade;
        $plan = Planos::find($request->plano)->nome;
        $cidade = TabelaOrigens::find($request->cidade)->nome;
        $plano_id = Planos::find($request->plano)->id;
        $tabela_origens_id = TabelaOrigens::find($request->cidade)->id;
        $co = ConfigurarCoparticipacao::where("plano_id",$plano_id)->where("tabela_origens_id",$tabela_origens_id)->first();
        return view('admin.pages.tabelas.coparticipacao',[
            "plano" => $plan,
            "cidade" => $cidade,
            "co" => $co,
            "plano_id" => $plano_id,
            "tabela_origens_id" => $tabela_origens_id
        ]);

    }

    public function storeCoparticipacao(Request $request)
    {
       $regras = [
            'consulta_eletivas' => 'required',
            'consulta_urgencia' => 'required',
            'exames_simples' => 'required',
            'exames_complexos' => 'required',
            'terapias' => 'required',
            'linha1' => 'nullable|min:3|max:255',
            'linha2' => 'nullable|min:3|max:255',
            'linha3' => 'nullable|min:3|max:255'
        ];

        // Mensagens de erro personalizadas
        $mensagens = [
            'required' => 'O campo :attribute é obrigatório.',
            "linha1.min" => "Esse campo deve ter no minimo 3 caracteres",
            "linha2.min" => "Esse campo deve ter no minimo 3 caracteres",
            "linha3.min" => "Esse campo deve ter no minimo 3 caracteres",
            "linha1.max" => "Esse campo deve ter no maximo 255 caracteres",
            "linha2.max" => "Esse campo deve ter no maximo 255 caracteres",
            "linha3.max" => "Esse campo deve ter no maximo 255 caracteres"

        ];

        // Executa a validação
        request()->validate($regras, $mensagens);

        $alt = ConfigurarCoparticipacao::where("plano_id",$request->plano_id)->where("tabela_origens_id",$request->tabela_origens_id);
        if($alt->count() == 1) {
            $a = $alt->first();
            $a->consultas_eletivas = str_replace([".",","],["","."],$request->consulta_eletivas);
            $a->consultas_urgencia = str_replace([".",","],["","."],$request->consulta_urgencia);
            $a->exames_simples = str_replace([".",","],["","."],$request->exames_simples);
            $a->exames_complexos = str_replace([".",","],["","."],$request->exames_complexos);
            $a->terapias = str_replace([".",","],["","."],$request->terapias);
            $a->linha01 = $request->linha1;
            $a->linha02 = $request->linha2;
            $a->linha03 = $request->linha3;
            $a->save();
        } else {
            $co = new ConfigurarCoparticipacao();
            $co->tabela_origens_id = $request->tabela_origens_id;
            $co->plano_id = $request->plano_id;
            $co->consultas_eletivas = str_replace([".",","],["","."],$request->consulta_eletivas);
            $co->consultas_urgencia = str_replace([".",","],["","."],$request->consulta_urgencia);
            $co->exames_simples = str_replace([".",","],["","."],$request->exames_simples);
            $co->exames_complexos = str_replace([".",","],["","."],$request->exames_complexos);
            $co->terapias = str_replace([".",","],["","."],$request->terapias);
            $co->linha01 = $request->linha1;
            $co->linha02 = $request->linha2;
            $co->linha03 = $request->linha3;
            $co->save();
        }

        


        return redirect()->back()->with('success',"Coparticipações inserida com sucesso");



    }






}
