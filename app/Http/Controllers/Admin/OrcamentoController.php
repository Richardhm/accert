<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Administradoras;
use Illuminate\Http\Request;

use PDF;

use App\Models\FaixaEtaria;
use App\Models\TabelaOrigens;
use App\Models\Corretora;
use App\Models\User;
use Illuminate\Support\Str;

class OrcamentoController extends Controller
{
    public function index()
    {

        $faixaEtaria = FaixaEtaria::all();
        $tabelaOrigem = TabelaOrigens::all();





        return view('admin.pages.orcamento.index',[
            "faixaEtaria" => $faixaEtaria,
            "cidades" => $tabelaOrigem
        ]);
    }

    public function criarPDFAmbulatorial(Request $request)
    {


        $linha01 = "";
        $linha02 = "";
        $linha03 = "";

        $consultas_eletivas = 0;
        $consultas_de_urgencia = 0;
        $exames_simples = 0;
        $exames_complexos = 0;
        $terapias = 0;


        $odonto = $request->odonto == "Com Odonto" ? 1 : 0;
        $cidade = $request->tabela_origem;
        $administradora = $request->administradora_id;
        $plano_id = $request->plano_id;

        $texto_odonto = $request->odonto;


        $plano = "";
        $plano_nome = "";
        $administradora_search = Administradoras::find($administradora);

        // if($administradora_search->nome == "Hapvida" || $administradora_search->nome == "hapvida") {
        //     $plano = "Indidivual";
        // } else {
        //     $plano = "Coletivo";
        // }

        $pdf = Corretora::first();


            $plano = "Individual";
            $plano_nome = "individual";
            $linha01 = $pdf->linha_01_individual;
            $linha02 = $pdf->linha_02_individual;
            $linha03 = $pdf->linha_03_individual;
            $consultas_eletivas     = $pdf->consultas_eletivas_individual;
            $consultas_de_urgencia  = $pdf->consultas_urgencia_individual;
            $exames_simples         = $pdf->exames_simples_individual;
            $exames_complexos       = $pdf->exames_complexos_individual;
            $terapias               = $pdf->terapias_individual;
            $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

        $quantidade = 0;
        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null) {
                $quantidade += $v;
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }

        if($quantidade > 6) {
            return "error_quantidade";
        } else {
            $chaves = implode(",",$chaves);
        }
        $ambulatorial = DB::select("
            SELECT
            nome,id_faixas,admin_logo,cidade,admin_id,plano,plano_id,titulos,card,admin_nome,quantidade,ambulatorial_com_coparticipacao,ambulatorial_com_coparticipacao_total,
            ambulatorial_sem_coparticipacao,ambulatorial_sem_coparticipacao_total
            FROM (
                SELECT
                    (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
                    (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
                    CASE
                        $sql
                        ELSE 0
                    END AS quantidade,
                    (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
                    (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
                    (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
                    (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
                    (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
                    (SELECT id FROM planos as pp WHERE pp.id = fora.plano_id) AS plano_id,

                    (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
                    (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_ambulatorial_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,

                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_com_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_com_coparticipacao_total,

                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_sem_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_sem_coparticipacao_total


                    from tabelas AS fora
                    WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id = $cidade AND administradora_id = $administradora AND
                    acomodacao_id = 3 AND valor != 0 AND odonto = $odonto
                    GROUP BY faixa_etaria_id,administradora_id,plano_id,tabela_origens_id,odonto ORDER BY id
                    )
                    AS full_tabela
        ");


        $site = $pdf->site;
        $endereco = $pdf->endereco;

        $icone_site_oficial = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/01.png")));
        $icone_boleto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/02.png")));
        $icone_marcar_consulta = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/03.png")));
        $icone_rede_atendimento = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/04.png")));
        $icone_clinica = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/05.png")));
        $icone_hospital = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/06.png")));
        $icone_lupa = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/07.png")));
        $icone_endereco = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/08.png")));
        $icone_zap_footer = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/telefone-consultar.png")));
        $site_icone = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/site.png")));
        // $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/logo.png")));
        $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$pdf->logo)));

        $cidade_nome = TabelaOrigens::find($cidade)->nome;

        $img = $pdf->logo;





        // if($administradora_search->nome == "Hapvida" || $administradora_search->nome == "hapvida" || $administradora_search->nome == "PME" || $administradora_search->nome == "Super Simples" || $administradora_search->nome == "Sindicato - Sindipão") {

        //     $linha01 = $pdf->linha_01_individual;
        //     $linha02 = $pdf->linha_02_individual;
        //     $linha03 = $pdf->linha_03_individual;

        //     $consultas_eletivas     = $pdf->consultas_eletivas_individual;
        //     $consultas_de_urgencia  = $pdf->consultas_urgencia_individual;
        //     $exames_simples         = $pdf->exames_simples_individual;
        //     $exames_complexos       = $pdf->exames_complexos_individual;
        //     $terapias               = $pdf->terapias_individual;



        //     $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

        // } else {
        //     $linha01 = $pdf->linha_01_coletivo;
        //     $linha02 = $pdf->linha_02_coletivo;
        //     $linha03 = $pdf->linha_03_coletivo;

        //     $consultas_eletivas = $pdf->consultas_eletivas_coletivo;
        //     $consultas_de_urgencia = $pdf->consultas_urgencia_coletivo;
        //     $exames_simples = $pdf->exames_simples_coletivo;
        //     $exames_complexos = $pdf->exames_complexos_coletivo;
        //     $terapias               = $pdf->terapias_coletivo;

        //     $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

        // }

        $user = User::find(auth()->user()->id);

       if($user) {
            $nome = $user->name;
            if($user->celular) {
                $telefone_user = $user->celular;
                $telefone_whattsap = str_replace([" ","(",")","-"],"",$user->celular);
            } else {
                $telefone_user = $pdf->celular;
                $telefone_whattsap = "";
            }
            if($user->image) {
                $t = new \App\Support\Thumb();
                $image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$user->image)));
            } else {
                $image_user = null;
            }
        }

        $frase_consultor = "";

        $view = \Illuminate\Support\Facades\View::make('admin.pages.orcamento.pdfambulatorial',[
            "frase_consultor" => $frase_consultor,
            "ambulatorial" => $ambulatorial,
            "nome" => $nome,
            "administradoras" => $administradora,
            "telefone" => $telefone_user,
            "telefone_whattsap" => $telefone_whattsap,
            "image"=>$image_user,
            "plano" => $plano,
            "icone_site_oficial"=>$icone_site_oficial,
            "icone_boleto"=>$icone_boleto,
            "icone_marcar_consulta" => $icone_marcar_consulta,
            "icone_rede_atendimento" => $icone_rede_atendimento,
            "icone_clinica" => $icone_clinica,
            "icone_hospital" => $icone_hospital,
            "icone_lupa" => $icone_lupa,
            "icone_endereco" => $icone_endereco,
            "icone_zap_footer" => $icone_zap_footer,
            "logo" => $logo,
            "nome_cidade" => $cidade_nome,
            "consultas_eletivas" => $consultas_eletivas,
            "consultas_de_urgencia" => $consultas_de_urgencia,
            "exames_simples" => $exames_simples,
            "exames_complexos" => $exames_complexos,
            "linha01" => $linha01,
            "linha02" => $linha02,
            "linha03" => $linha03,
            "site" => $site,
            "endereco" => $endereco,
            "terapias" => $terapias,
            "site_icone" => $site_icone,
            "texto_odonto" => $request->odonto

        ]);

        $nome_img = "orcamento_".$administradora_search->nome."_Ambulatorial_".date('d')."_".date('m')."_".date("Y")."_".date('H')."_".date("i");

        $pdfPath = storage_path('app/temp/temp.pdf');
        PDF::loadHTML($view)->save($pdfPath);


        $imagick = new \Imagick();
        $imagick->setResolution(300, 300); // Ajuste a resolução para 300 DPI (ou a resolução desejada)
        $imagick->readImage($pdfPath);
        $imagick->setImageFormat('png');

        $imagick->writeImage(storage_path("app/temp/{$nome_img}.png"));
        $imagick->clear();
        $imagick->destroy();
        // Retornar a imagem ou fazer qualquer outra operação necessária
        // Exemplo de download da imagem
        return response()
            ->download(storage_path("app/temp/{$nome_img}.png"))
            ->deleteFileAfterSend(true);
    }







    public function criarPDF(Request $request)
    {
        $linha01 = "";
        $linha02 = "";
        $linha03 = "";

        $consultas_eletivas = 0;
        $consultas_de_urgencia = 0;
        $exames_simples = 0;
        $exames_complexos = 0;
        $terapias = 0;


        $odonto = $request->odonto == "Com Odonto" ? 1 : 0;
        $cidade = $request->tabela_origem;
        $administradora = $request->administradora_id;
        $plano_id = $request->plano_id;

        $texto_odonto = $request->odonto;


        $plano = "";
        $plano_nome = "";
        $administradora_search = Administradoras::find($administradora);

        // if($administradora_search->nome == "Hapvida" || $administradora_search->nome == "hapvida") {
        //     $plano = "Indidivual";
        // } else {
        //     $plano = "Coletivo";
        // }

        $pdf = Corretora::first();

        if($plano_id == 1) {
            $plano = "Individual";
            $plano_nome = "individual";
            $linha01 = $pdf->linha_01_individual;
            $linha02 = $pdf->linha_02_individual;
            $linha03 = $pdf->linha_03_individual;


            if($cidade != 4) {
                $consultas_eletivas     = 20.00;
                $consultas_de_urgencia  = 30.00;
                $exames_simples         = 18.00;
                $exames_complexos       = 70.00;
                $terapias               = 61.20;
            } else {
                $consultas_eletivas     = $pdf->consultas_eletivas_individual;
                $consultas_de_urgencia  = $pdf->consultas_urgencia_individual;
                $exames_simples         = $pdf->exames_simples_individual;
                $exames_complexos       = $pdf->exames_complexos_individual;
                $terapias               = $pdf->terapias_individual;
            }








            $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";
            $nome_img = "orcamento_".$administradora_search->nome."_".$plano_nome."_".date('d')."_".date('m')."_".date("Y")."_".date("H")."_".date("i")."_".date("s");
        } else if($plano_id == 2) {
            $plano = "Corpore";
            $plano_nome = "corpore";
        } else if($plano_id == 3) {
            $plano = "Coletivo por Adesão";
            $plano_nome = "coletivo";
            $linha01 = $pdf->linha_01_coletivo;
            $linha02 = $pdf->linha_02_coletivo;
            $linha03 = $pdf->linha_03_coletivo;
            $consultas_eletivas = $pdf->consultas_eletivas_coletivo;
            $consultas_de_urgencia = $pdf->consultas_urgencia_coletivo;
            $exames_simples = $pdf->exames_simples_coletivo;
            $exames_complexos = $pdf->exames_complexos_coletivo;
            $terapias               = $pdf->terapias_coletivo;
            $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";
            $nome_img = "orcamento_".$administradora_search->nome."_".$plano_nome."_".date('d')."_".date('m')."_".date("Y")."_".date("H")."_".date("i")."_".date("s");
        } else if($plano_id == 4) {
            $plano = "PME";
            $plano_nome = "pme";
        } else if($plano_id == 5) {
            $plano = "Super Simples";
            $plano_nome = "Super Simples";
            $linha01 = "Adesão de R$ 15,00 reais por contrato";
            $linha02 = $pdf->linha_02_individual;
            $linha03 = $pdf->linha_03_individual;
            $consultas_eletivas     = 20.00;
            $consultas_de_urgencia  = 30.00;
            $exames_simples         = 18.00;
            $exames_complexos       = 70.00;
            $terapias               = 61.20;
            $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";
            $nome_img = "orcamento_".$administradora_search->nome."_".$plano_nome."_".date('d')."_".date('m')."_".date("Y")."_".date("H")."_".date("i")."_".date("s");
        } else if($plano_id == 6) {
            $plano = "Sindicato - Sindipão";
            $plano_nome = "Sindicato";
            $nome_img = "orcamento_".$administradora_search->nome."_".$plano_nome."_".date('d')."_".date('m')."_".date("Y")."_".date("H")."_".date("i")."_".date("s");
        } else if($plano_id == 8) {
            $plano = "Coletivo Integrado";
            $plano_nome = "coletivo";
            $linha01 = $pdf->linha_01_coletivo;
            $linha02 = $pdf->linha_02_coletivo;
            $linha03 = $pdf->linha_03_coletivo;
            $consultas_eletivas = $pdf->consultas_eletivas_coletivo;
            $consultas_de_urgencia = $pdf->consultas_urgencia_coletivo;
            $exames_simples = $pdf->exames_simples_coletivo;
            $exames_complexos = $pdf->exames_complexos_coletivo;
            $terapias               = $pdf->terapias_coletivo;
            $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";
            $nome_img = "orcamento_".$administradora_search->nome."_".$plano_nome."_".date('d')."_".date('m')."_".date("Y")."_".date("H")."_".date("i")."_".date("s");
        } else {
            $plano = "";
        }
        $quantidade = 0;
        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null) {
                $quantidade += $v;
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }

        if($quantidade > 6) {
            return "error_quantidade";
        } else {
            $chaves = implode(",",$chaves);

        $dados = DB::select("
        SELECT
        nome,id_faixas,quantidade,admin_logo,cidade,admin_id,plano,titulos,card,admin_nome,apartamento_com_coparticipacao,
        enfermaria_com_coparticipacao,apartamento_sem_coparticipacao,enfermaria_sem_coparticipacao

         FROM (
             SELECT
                 (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
                 (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
                 CASE
            $sql
            ELSE 0
        END AS quantidade,
                 (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
                 (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
                 (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
                 (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
                 (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
                 (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
                 (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao
                 from tabelas AS fora
                 WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id =  $cidade AND administradora_id = $administradora AND odonto = $odonto AND plano_id = $plano_id
                 GROUP BY faixa_etaria_id ORDER BY faixa_etaria_id
                 )
        AS full_tabela
        ");


        $site = $pdf->site;
        $endereco = $pdf->endereco;

        $icone_site_oficial = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/01.png")));
        $icone_boleto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/02.png")));
        $icone_marcar_consulta = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/03.png")));
        $icone_rede_atendimento = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/04.png")));
        $icone_clinica = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/05.png")));
        $icone_hospital = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/06.png")));
        $icone_lupa = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/07.png")));
        $icone_endereco = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/08.png")));
        $icone_zap_footer = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/telefone-consultar.png")));
        $site_icone = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/site.png")));
        // $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/logo.png")));
        $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$pdf->logo)));

        $cidade_nome = TabelaOrigens::find($cidade)->nome;

        $img = $pdf->logo;


        $user = User::find(auth()->user()->id);

       if($user) {
            $nome = $user->name;
            if($user->celular) {
                if(auth()->user()->id == 15) {
                    $telefone_user = $user->celular."- (62) 9 9358-1475";
                } else {
                    $telefone_user = $user->celular;
                }

                $telefone_whattsap = str_replace([" ","(",")","-"],"",$user->celular);
            } else {
                $telefone_user = $pdf->celular;
                $telefone_whattsap = "";
            }
            if($user->image) {
                $t = new \App\Support\Thumb();


                $image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$user->image)));
            } else {
                $image_user = null;
            }
        }

        if(auth()->user()->name == "Felipe Barros") {
            $frase_consultor = "Supervisor Comercial";
        } else {
            $frase_consultor = "Consultor de Vendas";
        }

        $view = \Illuminate\Support\Facades\View::make("admin.pages.orcamento.pdf2",[
            "frase_consultor" => $frase_consultor,
            "planos" => $dados,
            "nome" => $nome,
            "administradoras" => $administradora,
            "telefone" => $telefone_user,
            "telefone_whattsap" => $telefone_whattsap,
            "image"=>$image_user,
            "plano" => $plano,
            "icone_site_oficial"=>$icone_site_oficial,
            "icone_boleto"=>$icone_boleto,
            "icone_marcar_consulta" => $icone_marcar_consulta,
            "icone_rede_atendimento" => $icone_rede_atendimento,
            "icone_clinica" => $icone_clinica,
            "icone_hospital" => $icone_hospital,
            "icone_lupa" => $icone_lupa,
            "icone_endereco" => $icone_endereco,
            "icone_zap_footer" => $icone_zap_footer,
            "logo" => $logo,
            "nome_cidade" => $cidade_nome,
            "consultas_eletivas" => $consultas_eletivas,
            "consultas_de_urgencia" => $consultas_de_urgencia,
            "exames_simples" => $exames_simples,
            "exames_complexos" => $exames_complexos,
            "linha01" => $linha01,
            "linha02" => $linha02,
            "linha03" => $linha03,
            "site" => $site,
            "endereco" => $endereco,
            "terapias" => $terapias,
            "site_icone" => $site_icone,
            "quantidade" => $quantidade,
            "texto_odonto" => $texto_odonto,
            "plano_id" => $plano_id

        ]);

        $pdfPath = storage_path('app/temp/temp.pdf');
        PDF::loadHTML($view)->save($pdfPath);


        $imagick = new \Imagick();
        $imagick->setResolution(300, 300); // Ajuste a resolução para 300 DPI (ou a resolução desejada)
        $imagick->readImage($pdfPath);
        $imagick->setImageFormat('png');

        $imagick->writeImage(storage_path("app/temp/{$nome_img}.png"));
        $imagick->clear();
        $imagick->destroy();
        // Retornar a imagem ou fazer qualquer outra operação necessária
        // Exemplo de download da imagem
        return response()
            ->download(storage_path("app/temp/{$nome_img}.png"))
            ->deleteFileAfterSend(true);





        }



    }



    public function montarOrcamentoAdministradoras(Request $request)
    {
        $administradoras = Administradoras::orderBy('id', 'desc')->get();
        return view('admin.pages.orcamento.montarAdministradoras',[
            'admins' => $administradoras
        ]);
    }








//     public function criarPDF(Request $request)
//     {




//         $odonto = $request->odonto == "Com Odonto" ? 1 : 0;
//         $cidade = $request->tabela_origem;
//         $administradora = $request->administradora_id;
//         $plano_id = $request->plano_id;

//         $plano = "";
//         $plano_nome = "";
//         $administradora_search = Administradoras::find($administradora);

//         // if($administradora_search->nome == "Hapvida" || $administradora_search->nome == "hapvida") {
//         //     $plano = "Indidivual";
//         // } else {
//         //     $plano = "Coletivo";
//         // }

//         if($plano_id == 1) {
//             $plano = "Individual";
//             $plano_nome = "individual";
//         } else if($plano_id == 2) {
//             $plano = "Corpore";
//             $plano_nome = "corpore";
//         } else if($plano_id == 3) {
//             $plano = "Coletivo por Adesão";
//             $plano_nome = "coletivo";
//         } else if($plano_id == 4) {
//             $plano = "PME";
//             $plano_nome = "pme";
//         } else if($plano_id == 5) {
//             $plano = "Super Simples";
//             $plano_nome = "Super Simples";
//         } else if($plano_id == 6) {
//             $plano = "Sindicato - Sindipão";
//             $plano_nome = "Sindicato";
//         } else {
//             $plano = "";
//         }




//         $sql = "";
//         $chaves = [];
//         foreach($request->faixas[0] as $k => $v) {
//             if($v != null) {
//                 $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) = $k THEN $v ";
//                 $chaves[] = $k;
//             }
//         }
//         $chaves = implode(",",$chaves);





//         $dados = DB::select("SELECT
//             nome,id_faixas,admin_logo,cidade,admin_id,plano,titulos,card,admin_nome,quantidade,apartamento_com_coparticipacao,apartamento_com_coparticipacao_total,
//     enfermaria_com_coparticipacao,enfermaria_com_coparticipacao_total,apartamento_sem_coparticipacao,apartamento_sem_coparticipacao_total,enfermaria_sem_coparticipacao,
//     enfermaria_sem_coparticipacao_total
//             FROM (
//                 SELECT
//                     (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
//                     (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
//                     CASE
//                         $sql
//                         ELSE 0
//                     END AS quantidade,
//                     (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
//                     (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
//                     (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
//                     (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
//                     (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
//                     (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
//                     (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,
//                     (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao,
//                     (SELECT valor * quantidade FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao_total,
//                     (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao,
//                     (SELECT valor * quantidade FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao_total,
//                     (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao,
//                     (SELECT valor * quantidade FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao_total,
//                     (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao,
//                     (SELECT valor * quantidade FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao_total
//                     from tabelas AS fora
//                     WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id =  $cidade AND administradora_id = $administradora AND odonto = $odonto AND plano_id = $plano_id
//                     GROUP BY faixa_etaria_id,administradora_id,plano_id,tabela_origens_id,odonto ORDER BY id
//                     )
// AS full_tabela");





//         $pdf = Corretora::first();
//         $site = $pdf->site;
//         $endereco = $pdf->endereco;

//         $icone_site_oficial = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/01.png")));
//         $icone_boleto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/02.png")));
//         $icone_marcar_consulta = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/03.png")));
//         $icone_rede_atendimento = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/04.png")));
//         $icone_clinica = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/05.png")));
//         $icone_hospital = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/06.png")));
//         $icone_lupa = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/07.png")));
//         $icone_endereco = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/08.png")));
//         $icone_zap_footer = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/telefone-consultar.png")));
//         // $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/logo.png")));
//         $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$pdf->logo)));

//         $cidade_nome = TabelaOrigens::find($cidade)->nome;

//         $img = $pdf->logo;

//         $linha01 = "";
//         $linha02 = "";
//         $linha03 = "";

//         $consultas_eletivas = 0;
//         $consultas_de_urgencia = 0;
//         $exames_simples = 0;
//         $exames_complexos = 0;
//         $terapias = 0;



//         if($administradora_search->nome == "Hapvida" || $administradora_search->nome == "hapvida" || $administradora_search->nome == "PME" || $administradora_search->nome == "Super Simples" || $administradora_search->nome == "Sindicato - Sindipão") {

//             $linha01 = $pdf->linha_01_individual;
//             $linha02 = $pdf->linha_02_individual;
//             $linha03 = $pdf->linha_03_individual;

//             $consultas_eletivas     = $pdf->consultas_eletivas_individual;
//             $consultas_de_urgencia  = $pdf->consultas_urgencia_individual;
//             $exames_simples         = $pdf->exames_simples_individual;
//             $exames_complexos       = $pdf->exames_complexos_individual;
//             $terapias               = $pdf->terapias_individual;



//             $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

//         } else {
//             $linha01 = $pdf->linha_01_coletivo;
//             $linha02 = $pdf->linha_02_coletivo;
//             $linha03 = $pdf->linha_03_coletivo;

//             $consultas_eletivas = $pdf->consultas_eletivas_coletivo;
//             $consultas_de_urgencia = $pdf->consultas_urgencia_coletivo;
//             $exames_simples = $pdf->exames_simples_coletivo;
//             $exames_complexos = $pdf->exames_complexos_coletivo;
//             $terapias               = $pdf->terapias_coletivo;

//             $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

//         }

//         $user = User::find(auth()->user()->id);

//        if($user) {
//             $nome = $user->name;
//             if($user->celular) {
//                 $telefone_user = $user->celular;
//                 $telefone_whattsap = str_replace([" ","(",")","-"],"",$user->celular);
//             } else {
//                 $telefone_user = $pdf->celular;
//                 $telefone_whattsap = "";
//             }
//             if($user->image) {
//                 $image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$user->image)));
//             } else {
//                 $image_user = null;
//             }
//         }
//         if(auth()->user()->name == "Felipe Barros") {
//             $frase_consultor = "Supervisor Comercial";
//         } else {
//             $frase_consultor = "Consultor de Vendas";
//         }
//         $pdf = PDF::loadView('admin.pages.orcamento.pdf',[
//             "frase_consultor" => $frase_consultor,
//             "planos" => $dados,
//             "nome" => $nome,
//             "administradoras" => $administradora,
//             "telefone" => $telefone_user,
//             "telefone_whattsap" => $telefone_whattsap,
//             "image"=>$image_user,
//             "plano" => $plano,
//             "icone_site_oficial"=>$icone_site_oficial,
//             "icone_boleto"=>$icone_boleto,
//             "icone_marcar_consulta" => $icone_marcar_consulta,
//             "icone_rede_atendimento" => $icone_rede_atendimento,
//             "icone_clinica" => $icone_clinica,
//             "icone_hospital" => $icone_hospital,
//             "icone_lupa" => $icone_lupa,
//             "icone_endereco" => $icone_endereco,
//             "icone_zap_footer" => $icone_zap_footer,
//             "logo" => $logo,
//             "nome_cidade" => $cidade_nome,
//             "consultas_eletivas" => $consultas_eletivas,
//             "consultas_de_urgencia" => $consultas_de_urgencia,
//             "exames_simples" => $exames_simples,
//             "exames_complexos" => $exames_complexos,
//             "linha01" => $linha01,
//             "linha02" => $linha02,
//             "linha03" => $linha03,
//             "site" => $site,
//             "endereco" => $endereco,
//             "terapias" => $terapias
//         ]);
//         return $pdf->download(Str::kebab($nome_pdf));
//     }

    public function montarOrcamento(Request $request)
    {


        if(count(array_filter($request->faixas[0])) >= 7) {
            return "error_pdf";
        }

        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null AND $v != 0) {
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }
        $chaves = implode(",",$chaves);
        $cidade = $request->tabela_origem;
        $administradora = $request->administradora;
        $dados = DB::select("SELECT
            nome,id_faixas,admin_logo,cidade,admin_id,plano,plano_id,titulos,card,admin_nome,quantidade,apartamento_com_coparticipacao,apartamento_com_coparticipacao_total,
            enfermaria_com_coparticipacao,enfermaria_com_coparticipacao_total,apartamento_sem_coparticipacao,apartamento_sem_coparticipacao_total,enfermaria_sem_coparticipacao,
            enfermaria_sem_coparticipacao_total
            FROM (
                SELECT
                    (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
                    (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
                    CASE
                        $sql
                        ELSE 0
                    END AS quantidade,
                    (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
                    (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
                    (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
                    (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
                    (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
                    (SELECT id FROM planos as pp WHERE pp.id = fora.plano_id) AS plano_id,
                    (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
                    (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,
                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao_total,
                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao_total,
                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao_total,
                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao_total
                    from tabelas AS fora
                    WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id = $cidade AND administradora_id = $administradora
                    GROUP BY faixa_etaria_id,administradora_id,plano_id,tabela_origens_id,odonto ORDER BY id
                    )
                    AS full_tabela");





        $ambulatorial = DB::select("SELECT
            nome,id_faixas,admin_logo,cidade,admin_id,plano,plano_id,titulos,card,admin_nome,quantidade,ambulatorial_com_coparticipacao,ambulatorial_com_coparticipacao_total,
            ambulatorial_sem_coparticipacao,ambulatorial_sem_coparticipacao_total
            FROM (
                SELECT
                    (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
                    (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
                    CASE
                        $sql
                        ELSE 0
                    END AS quantidade,
                    (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
                    (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
                    (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
                    (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
                    (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
                    (SELECT id FROM planos as pp WHERE pp.id = fora.plano_id) AS plano_id,

                    (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
                    (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_ambulatorial_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,

                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_com_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_com_coparticipacao_total,

                    (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_sem_coparticipacao,
                    (SELECT valor  FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 3 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS ambulatorial_sem_coparticipacao_total


                    from tabelas AS fora
                    WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id = $cidade AND administradora_id = $administradora AND
                    acomodacao_id = 3 AND valor != 0
                    GROUP BY faixa_etaria_id,administradora_id,plano_id,tabela_origens_id,odonto ORDER BY id
                    )
                    AS full_tabela");







        return view('admin.pages.orcamento.montarPlanos',[
            "planos" => $dados,
            "ambulatorial" => $ambulatorial,
            'card_inicial' => count($dados) >= 1 ? $dados[0]->card : "",
            'card_incial_ambulatorial' => count($ambulatorial) >= 1 ? $ambulatorial[0]->card : ""
        ]);

    }

    public function criarPDFEmpresarial(Request $request)
    {
        $linha01 = "";
        $linha02 = "";
        $linha03 = "";

        $consultas_eletivas = 0;
        $consultas_de_urgencia = 0;
        $exames_simples = 0;
        $exames_complexos = 0;
        $terapias = 0;

        $odonto = $request->odonto == "Com Odonto" ? 1 : 0;
        $cidade = $request->tabela_origem;
        $administradora = $request->administradora_id;
        $plano_id = $request->plano_id;

        $plano = "";
        $plano_nome = "";
        $administradora_search = Administradoras::find($administradora);

        $pdf = Corretora::first();

        $plano = "Super Simples";
        $plano_nome = "Super Simples";
        $linha01 = "Adesão de R$ 15,00 reais por contrato";
        $linha02 = $pdf->linha_02_individual;
        $linha03 = $pdf->linha_03_individual;
        $consultas_eletivas     = 16.48;
        $consultas_de_urgencia  = 27.46;
        $exames_simples         = 16.48;
        $exames_complexos       = 67.92;
        $terapias               = 61.20;
        $nome_pdf = "orcamento ".$administradora_search->nome." ".$plano_nome."_".date('d/m/Y')."_".date('H:i').".pdf";

        $quantidade = 0;
        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null) {
                $quantidade += $v;
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }

        //if($quantidade > 6) {
            //return "error_quantidade";
        //} else {
            $chaves = implode(",",$chaves);
        //}

        $dados = DB::select("
        SELECT
        nome,id_faixas,quantidade,admin_logo,cidade,admin_id,plano,titulos,card,admin_nome,apartamento_com_coparticipacao,
        enfermaria_com_coparticipacao,apartamento_sem_coparticipacao,enfermaria_sem_coparticipacao

         FROM (
             SELECT
                 (SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS nome,
                 (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = fora.faixa_etaria_id) AS id_faixas,
                 CASE
            $sql
            ELSE 0
        END AS quantidade,
                 (SELECT logo FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_logo,
                 (SELECT nome FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_nome,
                 (SELECT id FROM administradoras as aa WHERE aa.id = fora.administradora_id) AS admin_id,
                 (SELECT nome FROM tabela_origens as cc WHERE cc.id = fora.tabela_origens_id) AS cidade,
                 (SELECT nome FROM planos as pp WHERE pp.id = fora.plano_id) AS plano,
                 (SELECT if(dentro.odonto = 0,'Sem Odonto','Com Odonto') AS odontos  FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS titulos,
                 (SELECT CONCAT((SELECT nome FROM administradoras as aa WHERE aa.id = dentro.administradora_id),'_',dentro.plano_id,'_',dentro.tabela_origens_id,'_',dentro.coparticipacao,'_',dentro.odonto) FROM tabelas AS dentro WHERE dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.coparticipacao = fora.coparticipacao AND dentro.odonto = fora.odonto AND dentro.tabela_origens_id = fora.tabela_origens_id AND dentro.faixa_etaria_id = fora.faixa_etaria_id LIMIT 1) AS card,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_com_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 1 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_com_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 1 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS apartamento_sem_coparticipacao,
                 (SELECT valor FROM tabelas AS dentro where dentro.administradora_id = fora.administradora_id AND dentro.plano_id = fora.plano_id AND dentro.tabela_origens_id = fora.tabela_origens_id AND acomodacao_id = 2 AND dentro.faixa_etaria_id = fora.faixa_etaria_id AND dentro.coparticipacao = 0 AND dentro.odonto = fora.odonto GROUP BY dentro.coparticipacao) AS enfermaria_sem_coparticipacao
                 from tabelas AS fora
                 WHERE fora.faixa_etaria_id IN($chaves) AND tabela_origens_id =  $cidade AND administradora_id = $administradora AND odonto = $odonto AND plano_id = $plano_id
                 GROUP BY faixa_etaria_id ORDER BY faixa_etaria_id
                 )
        AS full_tabela
        ");

        $user = User::find(auth()->user()->id);

       if($user) {
            $nome = $user->name;
            if($user->celular) {
                $telefone_user = $user->celular;
                $telefone_whattsap = str_replace([" ","(",")","-"],"",$user->celular);
            } else {
                $telefone_user = $pdf->celular;
                $telefone_whattsap = "";
            }
            if($user->image) {
                $t = new \App\Support\Thumb();


                $image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".$user->image)));
            } else {
                $image_user = null;
            }
        }



         $pdf = PDF::loadView('admin.pages.orcamento.empresarial',[
            "frase_consultor" => "",
            "planos" => $dados,
            "nome" => "teste",
            "administradoras" => $administradora,
            "telefone" => $telefone_user,
            "telefone_whattsap" => $telefone_whattsap,
            "image"=>$image_user,
            "plano" => $plano,
            //"icone_site_oficial"=>$icone_site_oficial,
            // "icone_boleto"=>$icone_boleto,
            // "icone_marcar_consulta" => $icone_marcar_consulta,
            // "icone_rede_atendimento" => $icone_rede_atendimento,
            // "icone_clinica" => $icone_clinica,
            // "icone_hospital" => $icone_hospital,
            // "icone_lupa" => $icone_lupa,
            // "icone_endereco" => $icone_endereco,
            // "icone_zap_footer" => $icone_zap_footer,
            "logo" => "",
            "nome_cidade" => "",
            "consultas_eletivas" => $consultas_eletivas,
            "consultas_de_urgencia" => $consultas_de_urgencia,
            "exames_simples" => $exames_simples,
            "exames_complexos" => $exames_complexos,
            "linha01" => $linha01,
            "linha02" => $linha02,
            "linha03" => $linha03,
            "site" => "",
            "endereco" => "",
            "terapias" => "",
            "site_icone" => ""
        ]);
        return $pdf->download(Str::kebab($nome_pdf));


    }


}
