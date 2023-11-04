<?php

namespace App\Exports;

use App\Models\Comissoes;
use App\Models\ComissoesCorretoresLancadas;
use App\Models\Contrato;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContratosExport implements FromCollection, WithHeadings, WithMapping
{
    private $mes;

    public function __construct($mes)
    {
        $this->mes = $mes;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $comissoes = ComissoesCorretoresLancadas::select(
            DB::raw('(select name from users where users.id = comissoes.user_id) as corretor'),
            DB::raw('(select nome from administradoras where administradoras.id = comissoes.administradora_id) as administradora'),
            DB::raw('(select nome from planos where planos.id = comissoes.plano_id) as plano'),
            DB::raw('
                COALESCE(
        CASE
            WHEN comissoes.empresarial THEN
                (SELECT valor_plano FROM contrato_empresarial WHERE contrato_empresarial.id = comissoes.contrato_empresarial_id)
            ELSE
                (SELECT valor_plano FROM contratos WHERE contratos.id = comissoes.contrato_id)
        END, 0) AS valor
            '),
            DB::raw('
                case when comissoes.empresarial then
                    (select cnpj from contrato_empresarial where contrato_empresarial.id = comissoes.contrato_empresarial_id)
                else
                    (SELECT cpf FROM clientes WHERE id = ((SELECT cliente_id FROM contratos WHERE contratos.id = comissoes.contrato_id)))
                END AS documento
            '),

            DB::raw('CASE WHEN comissoes.empresarial THEN
                     (SELECT quantidade_vidas FROM contrato_empresarial WHERE contrato_empresarial.id = comissoes.contrato_empresarial_id)
                 ELSE
                     (SELECT quantidade_vidas FROM clientes WHERE id = ((SELECT cliente_id FROM contratos WHERE contratos.id = comissoes.contrato_id)))
            END AS quantidade_vidas'),

            DB::raw('
                case when comissoes.empresarial then
                    (select codigo_externo from contrato_empresarial where contrato_empresarial.id = comissoes.contrato_empresarial_id)
                else
                    (SELECT codigo_externo FROM contratos WHERE contratos.id = comissoes.contrato_id)
                END AS codigo_externo
            '),



            DB::raw('
                COALESCE(
                CASE
                    WHEN comissoes.empresarial THEN
                        (SELECT desconto_corretor FROM contrato_empresarial WHERE contrato_empresarial.id = comissoes.contrato_empresarial_id)
                    ELSE
                        (SELECT desconto_corretor FROM contratos WHERE contratos.id = comissoes.contrato_id)
                END, 0) AS desconto

                '),
            DB::raw('
                case when comissoes.empresarial then
                    (select DATE_FORMAT(created_at,"%d/%m/%Y") from contrato_empresarial where contrato_empresarial.id = comissoes.contrato_empresarial_id)
                else
                    (select DATE_FORMAT(created_at,"%d/%m/%Y") from contratos where contratos.id = comissoes.contrato_id)
                END AS data_cadastro
                '),
            DB::raw('
                case when comissoes.empresarial then
                    (select DATE_FORMAT(vencimento_boleto,"%d/%m/%Y") from contrato_empresarial where contrato_empresarial.id = comissoes.contrato_empresarial_id)
                else
                    (select DATE_FORMAT(data_vigencia,"%d/%m/%Y") from contratos where contratos.id = comissoes.contrato_id)
                END AS data_vigencia
                '),

            DB::raw('CASE WHEN comissoes.empresarial THEN
                     (SELECT responsavel FROM contrato_empresarial WHERE contrato_empresarial.id = comissoes.contrato_empresarial_id)
                 ELSE
                     (SELECT nome FROM clientes WHERE id = ((SELECT cliente_id FROM contratos WHERE contratos.id = comissoes.contrato_id)))
            END AS cliente'),
            'parcela'
        )
            ->join('comissoes', 'comissoes.id', '=', 'comissoes_corretores_lancadas.comissoes_id')
            ->join('users', 'users.id', '=', 'comissoes.user_id')
            ->where('status_apto_pagar', 1)
            ->where('status_financeiro', 1)
            ->where('finalizado', 1)
            ->whereMonth('data_baixa_finalizado', '=', $this->mes)
            ->groupBy('comissoes_id')
            ->orderByRaw('corretor,plano')
            ->get();

        return $comissoes;



    }

    public function headings(): array
    {
        return [
          "Corretor",
            "Codigo",
            "Documento",
          "Cliente",
          "Administradora",
          "Plano",
          "Parcela",
          "Data Cadastro",
          "Data Vigencia",
          "Valor",
          "Desconto",
            "Vidas",

        ];
    }

    public function map($linha): array
    {
        return [
           $linha->corretor,
           $linha->codigo_externo,
           $linha->documento,
           $linha->cliente,
           $linha->administradora,
           $linha->plano,
           $linha->parcela,
           $linha->data_cadastro,
           $linha->data_vigencia,
           $linha->valor ?? 0,
           $linha->desconto,
           $linha->quantidade_vidas,

        ];
    }


}
