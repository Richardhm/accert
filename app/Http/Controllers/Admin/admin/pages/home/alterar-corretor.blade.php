@php $ii=0;@endphp
@for($i=0;$i < count($dados); $i++)
    @php 
        $ii++; 
        $plano = $dados[$i]->planos->id == 3 ? 'coletivo' : Illuminate\Support\Str::snake($dados[$i]->planos->nome,'')    
    @endphp

    @if($dados[$i]->plano_id == $plano_inicial && $dados[$i]->administradora_id == $administradora_id && $dados[$i]->tabela_origens_id == $tabela_origens_id)
        @if($ii == 1)
        <div class="col-2 d-flex justify-content-between p-1" style="border:3px solid #0dcaf0;border-radius:5px;background-color:#123449;color:#fff;margin-right:1%;box-shadow: 5px 0 8px rgb(65,105,225);">
        <table>
            <thead>
                <tr>
                    <td colspan="2" class="border-bottom border-white text-center">{{$dados[$i]->cidades->nome}}</td>
                </tr>
                <tr>
                    <td colspan="2" class="border-bottom border-white text-center">{{$dados[$i]->administradoras->nome}}</td>
                </tr>
                <tr>
                    <td colspan="2" class="border-bottom border-white text-center">{{$dados[$i]->planos->nome}}</td>
                </tr>
                <tr>
                    <td style="width:10%;font-size:0.8em;text-align:center;">Parcela</td>
                    <td style="width:10%;font-size:0.8em;text-align:center;">Valor</td>
                </tr>
            </thead>    
            <tbody>    
        @endif           
            <tr>
                <td style="width:5%;" class="text-center">{{$ii}}</td>
                <td style="width:20%;">
                <input type="text" name="parcela_{{$ii}}_{{$plano}}_{{$dados[$i]->administradoras->id}}_{{$dados[$i]->cidades->id}}_{{$dados[$i]->planos->id}}" style="width:100%;" value="{{$dados[$i]->valor}}" />
         
                </td>
            </tr>
    @else
    </tbody>
        </table>   
        </div>
        @php
            $plano_inicial      = $dados[$i]->plano_id;
            $administradora_id  = $dados[$i]->administradora_id;
            $tabela_origens_id  = $dados[$i]->tabela_origens_id;
            $ii=0;
            $i--;
       @endphp


    @endif

@endfor
</tbody>
        </table>   
        </div>

<div class="d-flex mt-2" style="flex-basis:100%;">
    <button class="btn btn-info btn-block btnAtualizarCorretor">Atualizar</button>
</div>


