<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\User;
use App\Models\cidadeCodigoVendedor;
use App\Models\TabelaOrigens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CorretorController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();
        $users = User::all();
        return view('admin.pages.corretores.index',[
            "cargos" => $cargos,
            "users" => $users
        ]);
    }

    public function listUser(Request $request)
    {
        if($request->ajax()) {
            $users = User::select('name','id')->orderBy("id","desc")->get();
            return response()->json($users);
        }
    }

    public function store(Request $request)
    {
        if($request->ajax()) {
            $logo = "";
            if($request->file('file')) {
                $file = $request->file('file');
                $filename = time().'_'.$file->getClientOriginalName();
                $location = 'storage/users';
                $uploadedFile = $file->move($location, $filename);
                $logo = str_replace("storage/","",$location).'/'.$filename;
            }

            $nome = $request->nome;
            $celular = $request->celular;
            $cidade = $request->cidade;
            $email = $request->email;
            $endereco = $request->endereco;
            $estado = $request->estado;
            $numero = $request->numero;
            $password = bcrypt($request->password);
            $cargo = $request->cargo;
            $cpf = $request->cpf;
            $ativo = $request->ativo_desativo;
            $cargo = $request->cargo;
            $tipo = $request->tipo;

            $user = new User();
            $user->name = $nome;
            $user->email = $email;
            $user->cidade = $cidade;
            $user->estado = $estado;
            $user->celular = $celular;
            $user->password = $password;
            $user->email = $email;
            $user->cargo_id = $cargo;
            $user->cpf = $cpf;
            $user->image = $logo;
            $user->numero = $numero;
            $user->cargo_id = $cargo;
            $user->tipo = $tipo;
            $user->ativo = $ativo;

            if($user->save()) {
                return $user->id;
            } else {
                return "error";
            }

        }
    }

    public function editarUser(Request $request)
    {

        $user = User::where("id",$request->id)->with("cargo")->first();
        $id = $request->id;

        $posicao = DB::select("
            WITH RankedUsers AS (
                SELECT
                    users.id,
                    COALESCE((clientes_sum + contrato_empresarial_sum), 0) AS quantidade,
                    RANK() OVER (ORDER BY COALESCE((clientes_sum + contrato_empresarial_sum), 0) DESC) AS posicao
                FROM users
                LEFT JOIN (
                    SELECT user_id, SUM(quantidade_vidas) AS clientes_sum
                    FROM clientes
                    GROUP BY user_id
                ) AS clientes ON clientes.user_id = users.id
                LEFT JOIN (
                    SELECT user_id, SUM(quantidade_vidas) AS contrato_empresarial_sum
                    FROM contrato_empresarial
                    GROUP BY user_id
                ) AS contrato_empresarial ON contrato_empresarial.user_id = users.id
            )
            SELECT id,quantidade, posicao
            FROM RankedUsers
            WHERE id = {$id};
        ")[0];


        $vendas = DB::select("
            select
                (select sum(valor_plano) from contratos where cliente_id in(select id from clientes where clientes.user_id = comissoes.user_id))
                +
                (select sum(valor_plano) from contrato_empresarial where contrato_empresarial.user_id = comissoes.user_id) as total
                from comissoes
                where user_id = {$id}
                group by comissoes.user_id;
        ");


        $administradoras = DB::select("
            SELECT
                administradoras.nome as admin,
                administradoras.logo as logo,
                coalesce(SUM(contratos.valor_plano), 0) + coalesce(SUM(contrato_empresarial.valor_plano), 0) AS total,
                coalesce(SUM(clientes.quantidade_vidas), 0) + coalesce(SUM(contrato_empresarial.quantidade_vidas), 0) AS quantidade_vidas
                FROM administradoras
                LEFT JOIN comissoes ON administradoras.id = comissoes.administradora_id AND comissoes.user_id = {$id}
                left join contratos on contratos.id = comissoes.contrato_id
                left join clientes on clientes.id = contratos.cliente_id
                left join contrato_empresarial on comissoes.contrato_empresarial_id = contrato_empresarial.id
            GROUP BY administradoras.id, administradoras.nome;
        ");

        // $cidades = DB::table('tabela_origens')
        // ->whereNotNull('codigo_cidade')
        // ->whereNotIn('id', function ($query) use($id) {
        //     $query->select('tabela_origens_id')
        //         ->from('cidade_codigo_vendedores')
        //         ->where('user_id', $id);
        // })
        // ->get();

        $cidades = DB::table('tabela_origens')->whereRaw('codigo_cidade IS NOT NULL')->get();
//        $comissao = "";
//
//        if(cidadeCodigoVendedor::where("user_id",$id)->count() >= 1) {
//            $comissao = cidadeCodigoVendedor::where("user_id",$id)->get();
//        }
        $cargos = Cargo::all();
        return view('admin.pages.corretores.edit',[
            "user" => $user,
            "cargos" => $cargos,
            "posicao" => $posicao->posicao,
            "quantidade_vidas" => $posicao->quantidade,
            "comissao" => "",
            "vendas" => count($vendas) >= 1 ? $vendas[0]->total : 0,
            "administradoras" => $administradoras,
            "cidades" => $cidades
        ]);
    }


    public function editarUserForm(Request $request)
    {

        $codigo_cidades = json_decode($request->input('codigo_cidade'), true);


        foreach ($codigo_cidades as $codigo_cidade) {
            if (isset($codigo_cidade['codigo_vendedor']) && isset($codigo_cidade['codigo_cidade'])) {
                $cidadeCodigoVendedor = new CidadeCodigoVendedor();
                $cidadeCodigoVendedor->codigo_tabela_origem = $codigo_cidade['codigo_cidade'];
                $cidadeCodigoVendedor->codigo_vendedor = $codigo_cidade['codigo_vendedor'];
                $cidadeCodigoVendedor->tabela_origens_id = $codigo_cidade['codigo_cidade'];
                $cidadeCodigoVendedor->user_id = $request->id;
                $cidadeCodigoVendedor->save();
            }
        }
        $id = $request->id;
        $user = User::find($id);
        if($request->password != null) {
            $password = bcrypt($request->password);
            $request->password = $password;
            $user->password = $password;
        }
        $nome = $request->nome;
        $cidade = $request->cidade;
        $estado = $request->estado;
        $celular = $request->celular;
        $cpf = $request->cpf;
        $email = $request->email;
        $numero = $request->numero;
        $ativo = $request->ativo_desativo;
        $cargo = $request->cargo;
        $tipo = $request->tipo;
        $user->name = $nome;
        $user->email = $email;
        $user->cidade = $cidade;
        $user->estado = $estado;
        $user->celular = $celular;
        $user->ativo = $request->status;
        $user->email = $email;
        $user->cargo_id = $cargo;
        $user->numero = $numero;
        $user->cpf = $cpf;
        if($request->file != 'undefined') {
            if($user->image) {
                if(file_exists("storage/".$user->image)) unlink("storage/".$user->image);
            }
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $location = 'storage/users';
            $uploadedFile = $file->move($location, $filename);
            $logo = str_replace("storage/","",$location).'/'.$filename;
            $user->image = $logo;
        }
        $user->cargo_id = $cargo;
        $user->tipo = $tipo;
        $user->ativo = $ativo;
        $user->save();

        return $user;
    }


}
