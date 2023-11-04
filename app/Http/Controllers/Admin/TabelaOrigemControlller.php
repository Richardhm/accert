<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelaOrigens;


class TabelaOrigemControlller extends Controller
{
    private $repository;

    public function __construct(TabelaOrigens $tabelaOrigens)
    {
        $this->repository = $tabelaOrigens;
    }

    public function index()
    {
        return view('admin.pages.tabela_origem.index');
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            return $this->repository->all();
        }
    }

    public function store(Request $request)
    {
          $cidade = $request->cidade;
          $uf = $request->uf;

          $to = new TabelaOrigens();
          $to->nome = $cidade;
          $to->uf = $uf;
          $to->save();

          $dados = TabelaOrigens::all();

          return view('admin.pages.home.tabela-origens',[
             "dados" => $dados
          ]);
    }

    public function deletar(Request $request)
    {
        $del = TabelaOrigens::find($request->id);
        $del->delete();
        
    }

}
