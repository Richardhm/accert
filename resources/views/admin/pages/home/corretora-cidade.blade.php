@php
    $plano_id = $dados[0]->plano_id;
    $administradora_id = $dados[0]->administradora_id;
    $tabela_origens_id = $dados[0]->tabela_origens_id;
    $ii=0;
@endphp

@for($i=0;$i < count($dados); $i++)

    @if($plano_id == $dados[$i]->plano_id && $administradora_id == $dados[$i]->administradora_id && $tabela_origens_id == $dados[$i]->tabela_origens_id)

        @php
            $ii++;
            $plano = $dados[$i]->plano_id == 3 ? 'coletivo' : $dados[$i]->plano;
        @endphp

        @if($ii == 1)
            <div class="col-2 d-flex justify-content-between" style="border:3px solid #0dcaf0;border-radius:5px;background-color:#123449;color:#fff;margin-right:1%;box-shadow: 5px 0 8px rgb(65,105,225);">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th colspan="2" style="font-size:0.875em;text-align:center;">{{$dados[$i]->cidade}}</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="font-size:0.875em;text-align:center;">{{$dados[$i]->administradora}}</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="font-size:0.875em;text-align:center;">{{$dados[$i]->plano}}</th>
                    </tr>    
                    <tr>
                        <th>Parcela</th>
                        <th>Valor</th>
                    </tr>    
                </thead>    
                <tbody>
        @endif
            <tr>
                <td style="width:10%;text-align:center;">{{$ii}}</td>
                <td style="width:20%;"><input type="text" value="{{$dados[$i]->valor}}" name="parcela_{{$ii}}_{{strtolower($dados[$i]->administradora)}}_{{Illuminate\Support\Str::snake($plano,'')}}_{{$dados[$i]->plano_id}}_{{$dados[$i]->administradora_id}}" style="width:100%;"></td>
                
            </tr>    
        

    @else
    </tbody>
            </table>
</div>
        @php
            $ii=0;

            $plano_id = $dados[$i]->plano_id;
            $administradora_id = $dados[$i]->administradora_id;
            $tabela_origens_id = $dados[$i]->tabela_origens_id;



            $i--;
        @endphp
    @endif




@endfor
</tbody>
            </table>
            </div>


<button class="btn btn-block btn-info btn-atualizar-corretora mt-2">Atualizar</button>            