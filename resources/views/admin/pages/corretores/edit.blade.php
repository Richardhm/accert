<div class="d-flex" style="flex-direction:column;flex-basis:100%;">
    <!--Linha 01-->
    <div>
        <div>
            <div class="card card-widget widget-user shadow">

                <div class="widget-user-header" style="background-color:#123449;">
                    <h3 class="widget-user-username text-white">{{$user->name}}</h3>
                    <h5 class="widget-user-desc text-white">{{ucfirst($user->cargo->nome)}}</h5>
                </div>

                
                @if(file_exists("storage/".$user->image))
                    <div class="widget-user-image" style="max-width:90px;max-height:90px;height:90px;width:90px;">
                        <img id="userImage" class="img-circle elevation-2 imagem-logo" style="width:100%;height:100%;" src="{{asset("storage/".$user->image)}}" alt="User Avatar">
                    </div>   
                @endif

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{number_format($vendas,2,",",".")}}</h5>
                                <span class="description-text">Vendas</span>
                            </div>

                        </div>

                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$posicao}}</h5>
                                <span class="description-text">Posição</span>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{$quantidade_vidas}}</h5>
                                <span class="description-text">Vidas</span>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--FIM Linha 01-->



    <!--Linha 02-->

    <div class="d-flex" style="justify-content: space-between;">

        @foreach($administradoras as $dd)
            
                <div style="background-color:white;border-radius:5px;">

                    <img src="{{asset($dd->logo)}}" class="card-img-top" alt="{{ $dd->admin }}" style="width: 40%;max-height:60px;">

                    <div>
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number" style="font-size:0.7em;">{{number_format($dd->total,2,",",".")}}</span>
                    </div>

                    <div>
                        <span class="info-box-text">Vidas</span>
                        <span class="info-box-number text-center" style="font-size:0.7em;">{{$dd->quantidade_vidas}}</span>
                    </div>
                </div>
            
        @endforeach
    </div>

    <!--FIM Linha 02-->


    <!--Linha 03-->
    <div class="mt-2">
        
            <form action="" method="post" name="editar_colaborador" class="border border-white rounded p-1 disabled" style="background-color:#123449;color:#FFF;">

                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Nome*</label>
                        <input type="text" class="form-control" id="name_editar" name="name_editar" placeholder="Nome" value="{{$user->name}}">

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf_editar" name="cpf_editar" placeholder="CPF" value="{{$user->cpf}}">

                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Foto:</label>
                    <input type="file" class="form-control" id="image_editar" name="image_editar">

                </div>


                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label for="endereco">Endereco:</label>
                        <input type="text" class="form-control" id="endereco_editar" name="endereco_editar" placeholder="Endereco" value="{{old('endereco')}}">

                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="numero">Numero:</label>
                        <input type="text" class="form-control" id="numero_editar" name="numero_editar" placeholder="Nº" value="{{$user->numero}}">

                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cidade">Cidade:</label>
                        <input type="text" class="form-control" id="cidade_editar" name="cidade_editar" placeholder="Cidade" value="{{$user->cidade}}">

                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="estado" class="control-label">Estado:</label>
                        <select id="estado_editar" name="estado_editar" class="form-control select2-single">
                            <option value="">Escolha o estado</option>
                            <option value="AC" {{$user->estado == "AC" ? 'selected' : ''}}>Acre</option>
                            <option value="AL" {{$user->estado == "AL" ? 'selected' : ''}}>Alagoas</option>
                            <option value="AP" {{$user->estado == "AP" ? 'selected' : ''}}>Amapá</option>
                            <option value="AM" {{$user->estado == "AM" ? 'selected' : ''}}>Amazonas</option>
                            <option value="BA" {{$user->estado == "BA" ? 'selected' : ''}}>Bahia</option>
                            <option value="CE" {{$user->estado == "CE" ? 'selected' : ''}}>Ceará</option>
                            <option value="DF" {{$user->estado == "DF" ? 'selected' : ''}}>Distrito Federal</option>
                            <option value="ES" {{$user->estado == "ES" ? 'selected' : ''}}>Espírito Santo</option>
                            <option value="GO" {{$user->estado == "GO" ? 'selected' : ''}}>Goiás</option>
                            <option value="MA" {{$user->estado == "MA" ? 'selected' : ''}}>Maranhão</option>
                            <option value="MT" {{$user->estado == "MT" ? 'selected' : ''}}>Mato Grosso</option>
                            <option value="MS" {{$user->estado == "MS" ? 'selected' : ''}}>Mato Grosso do Sul</option>
                            <option value="MG" {{$user->estado == "MG" ? 'selected' : ''}}>Minas Gerais</option>
                            <option value="PA" {{$user->estado == "PA" ? 'selected' : ''}}>Pará</option>
                            <option value="PB" {{$user->estado == "PB" ? 'selected' : ''}}>Paraíba</option>
                            <option value="PR" {{$user->estado == "PR" ? 'selected' : ''}}>Paraná</option>
                            <option value="PE" {{$user->estado == "PE" ? 'selected' : ''}}>Pernambuco</option>
                            <option value="PI" {{$user->estado == "PI" ? 'selected' : ''}}>Piauí</option>
                            <option value="RJ" {{$user->estado == "RJ" ? 'selected' : ''}}>Rio de Janeiro</option>
                            <option value="RN" {{$user->estado == "RN" ? 'selected' : ''}}>Rio Grande do Norte</option>
                            <option value="RS" {{$user->estado == "RS" ? 'selected' : ''}}>Rio Grande do Sul</option>
                            <option value="RO" {{$user->estado == "RO" ? 'selected' : ''}}>Rondônia</option>
                            <option value="RR" {{$user->estado == "RR" ? 'selected' : ''}}>Roraima</option>
                            <option value="SC" {{$user->estado == "SC" ? 'selected' : ''}}>Santa Catarina</option>
                            <option value="SP" {{$user->estado == "SP" ? 'selected' : ''}}>São Paulo</option>
                            <option value="SE" {{$user->estado == "SE" ? 'selected' : ''}}>Sergipe</option>
                            <option value="TO" {{$user->estado == "TO" ? 'selected' : ''}}>Tocantins</option>
                        </select>

                    </div>





                </div>

                <div class="form-row">

                    <div class="col-md-4 mb-3">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" id="celular_editar" name="celular_editar" placeholder="(XX) X XXXXX-XXXX" value="{{$user->celular}}">

                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password">Senha:*</label>
                        <input type="password" class="form-control" id="password_editar" name="password_editar" placeholder="Senha" value="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email">Email:*</label>
                        <input type="text" class="form-control" id="email_editar" name="email_editar" placeholder="Email" value="{{$user->email}}">

                    </div>



                </div>




                <div class="d-flex justify-content-between">
                    <div class="w-25">
                        <label for="cargo">Cargo</label>
                        <div class="d-flex">
                            <select name="cargo_editar" id="cargo_editar" class="form-control">
                            @foreach($cargos as $c)
                                <option id="cargo_{{$c->nome}}" name="cargo_{{$c->nome}}" value="{{$c->id}}" {{$user->cargo_id == $c->id ? 'selected' : ''}}>{{$c->nome}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-25">

                         <label for="tipo">Tipo</label>
                        <div class="d-flex">
                            <select name="tipo_editar" id="tipo_editar" class="form-control">
                                <option value="">--Escolher--</option>
                                <option id="tipo_clt" name="tipo_clt" value="1" {{$user->tipo == 1 ? 'selected' : ''}}>CLT</option>
                                <option id="tipo_parceiro" name="tipo_parceiro" value="2" {{$user->tipo == 2 ? 'selected' : ''}}>Parceiro</option>
                            
                            </select>
                        </div>



                    </div>

                    <div class="w-25">
                        <label for="">Ativado/Desativado</label>
                        <select name="ativo_desativo_editar" id="ativo_desativo_editar" class="form-control">
                            <option value="">--Escolher--</option>
                            <option value="1" {{$user->ativo == 1 ? 'selected' : ''}}>Ativado</option>
                            <option value="0" {{$user->ativo == 0 ? 'selected' : ''}}>Desativado</option>
                        </select>
                    </div>






                </div>

                <div class="border-top mt-2">
                    <h4>Importante: Vincular Codigo Corretor com Cidade clicar no botão ao lado <i id="adicionarCampo" class="fas fa-plus"></i></h4>
                    <div id="camposDinamicos">
                        @if($comissao != null)
                            @foreach($comissao as $cc)
                                <div div class='row'>
                                    <div class='col-2'>
                                        <input type="text" name="codigo_vendedor[]" value="{{ $cc->codigo_vendedor }}" class="form-control">
                                    </div>
                                    <div class='col-2'>
                                        <select name="codigo_cidade[]" class="form-control">
                                            <option value="">Selecione uma cidade</option>
                                            @foreach ($cidades as $cidadeOrigem)
                                                <option value="{{ $cidadeOrigem->id }}" {{ $cidadeOrigem->id == $cc->tabela_origens_id ? 'selected' : '' }} data-codigo="{{ $cidadeOrigem->codigo_cidade }}">{{ $cidadeOrigem->nome }} - {{ $cidadeOrigem->codigo_cidade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="removerCampo">Remover</button>
                                </div>

                            @endforeach
                        @endif
                    </div>
                    
                </div>

                <button class="btn btn-primary btn-block mt-2 btn_primary editar_user">Editar</button>
                <input type="hidden" id="id" name="id" value="{{$user->id}}">
            </form>
    </div>
    <!--FIM Linha 03-->
</div>

<script>
    $(document).ready(function() {
        let cidades = @json($cidades);
        
        $("#adicionarCampo").click(function() {
            let novoCampo = `
                <div class='row'>
                    <div class='col-2'>
                        <input type="text" name="codigo_vendedor[]" class="form-control">
                    </div> 
                    <div class='col-2'>
                        <select name="codigo_cidade[]" class="form-control">
                            <option value="">Selecione uma cidade</option>
                            ${cidades.map(cidade => `<option value="${cidade.id}" data-codigo="${cidade.codigo_cidade}">${cidade.nome} - ${cidade.codigo_cidade}</option>`).join('')}
                        </select>
                        
                    </div>
                    <i class="fas fa-times removerCampo"></i>
                </div>
            `;
            $("#camposDinamicos").append(novoCampo);
        });

        $("#camposDinamicos").on("click", ".removerCampo", function() {
            $(this).parent().remove();
        });




    });    
</script>    


    







    