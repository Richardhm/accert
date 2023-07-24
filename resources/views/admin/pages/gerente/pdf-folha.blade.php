<html>
    <head>
        <title></title>
        <style>
            * {margin:0;padding:0;font-size:1em;}
            td {font-size: 0.7em;}
        </style>
    </head>
    <body>
       <div style="width:95%;margin:0 auto;padding:5px 0;">
            <p style="font-size:0.75em;">ACCERT CORRETORA</p>
       </div>

       <div style="border-top:1px solid black;display:block;width:95%;left:20px;position:absolute;height:70px;padding:10px 0;">
            <div style="width:90%;position:relative;left:0;float:left;">
                <p>COMPOSIÇÃO SALARIAL</p>
                <p>Vendedor: {{$user}}</p>
                <p>Referência: {{$meses}} / 2023</p>
            </div>

            <div style="width:10%;position:relative;right:0;top:0;margin-bottom:5px;float:right;background-color:#A9A9A9;padding:2px;border-radius:5px;">
                <img src="{{$logo}}" alt="Logo" id="Logo" style="width:100%;height:100%;" />
            </div>

       </div>


       <div style="clear: both;"></div>


       <div style="display:block;height:80px;width:95%;left:20px;position:relative;border-top:1px solid black;padding:2px;">
            <div>
                <span style="width:89%;left:0;float:left;">1 Salário Mês</span>
                <span style="width:11%;right:0;top:0;float:right;text-align:right;">
                    <div style="width:75%;float:right;text-align:right;">{{number_format($salario,2,",",".")}}</div>
                </span>
            </div>
            <div style="clear: both;"></div>
            <div>
                <span style="width:89%;left:0;float:left;">1 Comissão</span>
                <div style="width:11%;right:0;top:0;float:right;">

                    <div style="width:75%;float:right;text-align:right;">{{number_format($comissao,2,",",".")}}</div>
                </div>

            </div>
            <div style="clear: both;"></div>
            <div>
                <span style="width:89%;left:0;float:left;">1 Premiação</span>
                <div style="width:11%;right:0;top:0;float:right;">
                    <div style="width:75%;float:right;text-align:right;">{{number_format($premiacao,2,",",".")}}</div>
                </div>
            </div>
            <div style="clear: both;"></div>

           <div>
               <span style="width:89%;left:0;float:left;">1 Desconto</span>
               <span style="width:11%;right:0;top:0;float:right;text-align:right;">{{number_format($desconto,2,",",".")}}</span>
           </div>

           <div style="clear: both;"></div>
            <div>
                <span style="width:50%;left:0;float:left;">Total Geral</span>
                <span style="width:40%;right:0;top:0;float:right;text-align:right;">{{number_format($total,2,",",".")}}</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div style="border-top:1px solid black;width:95%;margin:0 auto;border-bottom:1px solid black;padding:5px 0;">
            <p style="font-size:0.875em;">ACOMPANHAMENTO DE VENDAS</p>
            <p style="font-size:0.875em;">Período de {{$primeiro_dia}} até {{$ultimo_dia}}</p>
            <p style="font-size:0.875em;">Status: Somente Pago</p>
        </div>

        <div style="clear: both;"></div>

        @php
            $total_plano_individual = 0;
            $total_comissao_individual = 0;
            $total_desconto_individual = 0;
            $total_valor_individual = 0;
            $total_plano_coletivo = 0;
            $total_comissao_coletivo = 0;
            $total_plano_empresarial = 0;
            $total_comissao_empresarial = 0;
        @endphp

        @if(count($individual) >= 1)





        <div style="width:95%;border-bottom:1px solid black;margin:0 auto;background-color:rgb(231,230,230);font-weight:bold;padding:5px 0;">Plano Individual</div>

        <table style="width:95%;margin:0 auto;">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td>Admin</td>
                    <td>Contrato</td>
                    <td>Data</td>
                    <td>Cliente</td>
                    <td>Parcela</td>
                    <td align="center">Valor</td>
                    <td align="center">Desconto</td>
                    <td align="center">Plano</td>
                    <td align="right">Comissão</td>
                </tr>
            </thead>
            <tbody>

                @foreach($individual as $d)
                    @php
                        $total_plano_individual += $d->comissao->contrato->valor_plano;
                        $total_comissao_individual += $d->valor_pago != null ? $d->valor_pago : $d->valor;

                        $total_desconto_individual += $d->comissao->contrato->desconto_corretor;
                        $total_valor_individual    += $d->comissao->contrato->valor_plano;


                    @endphp
                    <tr>
                        <td style="width:10%;">HAPVIDA</td>
                        <td style="width:8%;">{{$d->comissao->contrato->codigo_externo}}</td>
                        <td style="width:8%;">{{date('d/m/Y',strtotime($d->comissao->contrato->created_at))}}</td>
                        <td style="font-size:0.6em;width:35%;">{{mb_convert_case($d->comissao->contrato->clientes->nome,MB_CASE_UPPER,"UTF-8")}}</td>
                        <td style="width:7%;">Parcela {{$d->parcela}}</td>
                        <td style="width:7%;" align="center">{{number_format($d->comissao->contrato->valor_plano,2,",",".")}}</td>
                        <td style="width:8%;" align="center">{{$d->comissao->contrato->desconto_corretor}}</td>
                        <td style="width:7%;" align="center">{{number_format($d->comissao->contrato->valor_plano,2,",",".")}}</td>
                        <td style="width:5%;" align="right">{{$d->valor_pago != null ? number_format($d->valor_pago,2,",",".") : number_format($d->valor,2,",",".")}}</td>
                    </tr>
                @endforeach

            </tbody>

            <tfoot style="border-top:1px solid black;">
                <tr>
                    <td colspan="5"></td>
                    <td align="center">
                        @php
                            echo number_format($total_valor_individual,2,",",".");
                        @endphp
                    </td>
                    <td align="center">
                        @php
                            echo number_format($total_desconto_individual,2,",",".");
                        @endphp
                    </td>
                    <td align="center">
                        @php
                            echo number_format($total_plano_individual,2,",",".");
                        @endphp
                    </td>
                    <td align="right">
                        @php
                           echo number_format($total_comissao_individual,2,",",".");
                        @endphp
                    </td>
                </tr>
            </tfoot>



        </table>


        @endif

        @if(count($coletivo) >= 1)

            @php
                $contrato_coletivo = $coletivo[0]->comissao->contrato->codigo_externo;
                $contrato_coletivo_total = 0;
                $contrato_coletivo_plano = 0;
                $ii=0;
                $status=null;
            @endphp
        <div style="width:95%;border-bottom:1px solid black;margin:0 auto;background-color:rgb(231,230,230);font-weight:bold;padding:5px 0;">Plano Coletivo</div>
        <table style="width:95%;margin:0 auto;">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td>Admin</td>
                    <td>Contrato</td>
                    <td>Data</td>
                    <td>Cliente</td>
                    <td>Parcela</td>
                    <td align="center">Valor</td>
                    <td align="center">Desconto</td>
                    <td align="center">Plano</td>
                    <td align="right">Comissão</td>
                </tr>
            </thead>
            <tbody>
                @foreach($coletivo as $d)
                    @php
                    if($d->comissao->contrato->codigo_externo == $contrato_coletivo) {
                        $status=1;
                        $ii++;

                    } else {
                        $contrato_coletivo = $d->comissao->contrato->codigo_externo;
                        $status=1;
                        $ii=1;
                    }


                    @endphp
                    @php
                        if(isset($d->comissao->contrato->valor_plano) && !empty($d->comissao->contrato->valor_plano) && $d->comissao->contrato->valor_plano) {
                            $total_plano_coletivo += $d->comissao->contrato->valor_plano;
                            $total_comissao_coletivo += $d->valor_pago != null ? $d->valor_pago : $d->valor;
                        }
                    @endphp
                    <tr>
                        <td style="width:10%;">{{$d->comissao->administradoras->nome}}</td>
                        <td style="width:8%;">{{$d->comissao->contrato->codigo_externo}}</td>
                        <td style="width:8%;">{{date('d/m/Y',strtotime($d->comissao->contrato->created_at))}}</td>
                        <td style="font-size:0.6em;width:35%;">{{mb_convert_case($d->comissao->contrato->clientes->nome,MB_CASE_UPPER,"UTF-8")}}</td>
                        <td style="width:7%;">Parcela {{$d->parcela}}</td>
                        <td style="width:7%;" align="center">
                            @php
                                $contrato_coletivo_plano += $d->comissao->contrato->valor_plano;
                                echo number_format($d->comissao->contrato->valor_plano,2,",",".");
                            @endphp
                        </td>
                        <td style="width:8%;" align="center">
                                @if($status == 1 && $ii == 1)
                                    @php
                                        $contrato_coletivo_total += $d->comissao->contrato->desconto_corretor;
                                        echo number_format($d->comissao->contrato->desconto_corretor,2,",",".");
                                    @endphp
                                @else
                                        0
                                @endif
                        </td>
                        <td style="width:7%;" align="center">{{number_format($d->comissao->contrato->valor_plano,2,",",".")}}</td>
                        <td style="width:5%;" align="right">{{$d->valor_pago != null ? number_format($d->valor_pago,2,",",".") : number_format($d->valor,2,",",".")}}</td>
                    </tr>
                    @php
                        $status=0;
                    @endphp
                @endforeach
            </tbody>

            <tfoot style="border-top:1px solid black;">
                <tr>
                    <td colspan="5"></td>

                    <td align="center">
                        @php
                            echo number_format($contrato_coletivo_plano,2,",",".");
                        @endphp
                    </td>

                    <td align="center">
                        @php
                            echo number_format($contrato_coletivo_total,2,",",".");
                        @endphp
                    </td>

                    <td align="center">
                        @php
                            echo number_format($total_plano_coletivo,2,",",".") ?? '';
                        @endphp
                    </td>
                    <td align="right">
                        @php
                           echo number_format($total_comissao_coletivo,2,",",".") ?? '';
                        @endphp
                    </td>
                </tr>
            </tfoot>




        </table>


        @endif

        @if(count($empresarial) >= 1)
        <div style="width:95%;border-bottom:1px solid black;margin:0 auto;background-color:rgb(231,230,230);font-weight:bold;padding:5px 0;">Empresarial</div>
        <table style="width:95%;margin:0 auto;">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td>Admin</td>
                    <td>Contrato</td>
                    <td align="center">Data</td>
                    <td>Cliente</td>
                    <td align="center">Parcela</td>
                    <td align="center">Valor</td>
                    <td>Desconto</td>
                    <td align="center">Comissão</td>
                </tr>
            </thead>
            <tbody>
                @foreach($empresarial as $d)
                    @php
                        $total_plano_empresarial += $d->comissao->contrato_empresarial->valor_plano;
                        $total_comissao_empresarial += $d->valor_pago != null ? $d->valor_pago : $d->valor;
                    @endphp
                    <tr>
                        <td>HAPVIDA</td>
                        <td>{{$d->comissao->contrato_empresarial->codigo_externo}}</td>
                        <td align="center">{{date('d/m/Y',strtotime($d->comissao->contrato_empresarial->created_at))}}</td>
                        <td>{{mb_convert_case($d->comissao->contrato_empresarial->responsavel,MB_CASE_UPPER,"UTF-8")}}</td>
                        <td align="center">Parcela {{$d->parcela}}</td>
                        <td align="center">{{number_format($d->comissao->contrato_empresarial->valor_plano,2,",",".")}}</td>
                        <td>{{number_format($d->comissao->contrato_empresarial->desconto_corretor,2,",",".")}}</td>
                        <td align="center">{{$d->valor_pago != null ? number_format($d->valor_pago,2,",",".") : number_format($d->valor,2,",",".")}}</td>
                    </tr>
                @endforeach

            </tbody>

            <tfoot style="border-top:1px solid black;">
                <tr>
                    <td colspan="6"></td>
                    <td>
                        @php
                            echo number_format($total_plano_empresarial,2,",",".") ?? '';
                        @endphp
                    </td>
                    <td>
                        @php
                           echo number_format($total_comissao_empresarial,2,",",".") ?? '';
                        @endphp
                    </td>
                </tr>
            </tfoot>








        </table>


        @endif



    </body>
</html>
