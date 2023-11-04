<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\User;
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
            $users = User::select('name','id')
                ->orderBy("id","desc")
                ->get();
            return response()->json($users);
        }

    }

    public function store(Request $request)
    {
        if($request->ajax()) {
             $file = $request->file('file');
             $filename = time().'_'.$file->getClientOriginalName();
             //Nome da Pasta de Destino
             //$location = 'storage/users';

             // Realizar Upoload da Imagem

            $location = 'storage/users';
            //$location_storage = 'public/users';
            //$location_storage = storage_path()."/app/public/users/";
            $uploadedFile = $file->move($location, $filename);
            //Storage::disk('local')->copy($uploadedFile, $location_storage.'/'.$filename);

            //Storage::disk('local')->move($location_storage,$filename);



            //$file->move($location,$filename);
             //$file->move($location_storage,$filename);
             // $filepath = url($location.'/'.$filename);
             $logo = str_replace("storage/","",$location).'/'.$filename;
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


             $user = new User();
             $user->name = $nome;
             $user->email = $email;
             $user->cidade = $cidade;
             $user->estado = $estado;
             $user->celular = $celular;
             $user->password = $password;
             $user->email = $email;
             //$user->cargo_id = $cargo;
             $user->cpf = $cpf;
             $user->image = $logo;
             $user->numero = $numero;
             $user->save();





             //$user->cpf = $





        }
    }

    public function editarUser(Request $request)
    {

        $user = User::where("id",$request->id)->with("cargo")->first();
        $id = $request->id;
        $posicao = DB::select("
            SELECT
                quantidade_vidas,
                (
                    SELECT COUNT(*)
                    FROM (
                        SELECT
                            users.id AS user_id,
                            (select COALESCE(sum(quantidade_vidas),0) from clientes where clientes.user_id = comissoes.user_id) +
                            (select COALESCE(sum(quantidade_vidas),0) from contrato_empresarial where contrato_empresarial.user_id = comissoes.user_id) AS quantidade_vidas
                            FROM comissoes
                            LEFT JOIN clientes ON clientes.user_id = comissoes.user_id
                            LEFT JOIN contrato_empresarial ON contrato_empresarial.user_id = comissoes.user_id
                            INNER JOIN users ON users.id = comissoes.user_id
                            GROUP BY users.name
                        ) AS subquery
                        WHERE subquery.quantidade_vidas > ranked_vendedores.quantidade_vidas
                    ) + 1 AS posicao
                    FROM (
                        SELECT
                            users.id AS user_id,
                            (select COALESCE(sum(quantidade_vidas),0) from clientes where clientes.user_id = comissoes.user_id) +
                            (select COALESCE(sum(quantidade_vidas),0) from contrato_empresarial where contrato_empresarial.user_id = comissoes.user_id) AS quantidade_vidas
                            FROM comissoes
                            LEFT JOIN clientes ON clientes.user_id = comissoes.user_id
                            LEFT JOIN contrato_empresarial ON contrato_empresarial.user_id = comissoes.user_id
                            INNER JOIN users ON users.id = comissoes.user_id
                            GROUP BY users.name
                        ) AS ranked_vendedores
                    WHERE user_id = {$id};
            ");



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







        $cargos = Cargo::all();
        return view('admin.pages.corretores.edit',[
            "user" => $user,
            "cargos" => $cargos,
            "posicao_qtd_vidas" => $posicao[0],
            "vendas" => $vendas[0]->total,
            "administradoras" => $administradoras
        ]);
    }


    public function editarUserForm(Request $request)
    {



        $id = $request->id;
        $user = User::find($id);

        if($request->password != null) {
            $password = bcrypt($request->password);
            $request->password = $password;
        }
        $nome = $request->nome;
        $cidade = $request->cidade;
        $estado = $request->estado;
        $celular = $request->celular;
        $cpf = $request->cpf;
        $email = $request->email;
        $numero = $request->numero;
        $cargo = $request->cargo;

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

                if(file_exists("storage/".$user->image)) {
                    unlink("storage/".$user->image);

                    $file = $request->file('file');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $location = 'storage/users';
                    $uploadedFile = $file->move($location, $filename);
                    $logo = str_replace("storage/","",$location).'/'.$filename;
                    $user->image = $logo;
                }
            }
        }
        $user->save();

        return $user;
    }


}
