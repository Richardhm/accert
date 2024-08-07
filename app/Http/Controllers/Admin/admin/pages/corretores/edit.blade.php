@extends('adminlte::page')
@section('title', 'Editar')
@section('content')

    <div class="row">

        <div class="col-12">

            <div class="card card-widget widget-user shadow">

                <div class="widget-user-header bg-navy">
                    <h3 class="widget-user-username">{{$user->name}}</h3>
                    <h5 class="widget-user-desc">{{ucfirst($user->cargo->nome)}}</h5>
                </div>

                <div class="widget-user-image">
                    <img class="img-circle elevation-2 imagem-logo" src="{{asset("storage/".$user->image)}}" alt="User Avatar">
                </div>

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
                                <h5 class="description-header">{{$posicao_qtd_vidas->posicao}}</h5>
                                <span class="description-text">Posição</span>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{$posicao_qtd_vidas->quantidade_vidas}}</h5>
                                <span class="description-text">Vidas</span>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="row">


        @foreach($administradoras as $dd)

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">

                    <img src="{{asset($dd->logo)}}" class="card-img-top" alt="{{ $dd->admin }}" style="width: 60%;max-width:60%;max-height:60px;">

                    <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number" style="font-size:0.7em;">{{number_format($dd->total,2,",",".")}}</span>
                    </div>

                    <div class="info-box-content">
                        <span class="info-box-text">Vidas</span>
                        <span class="info-box-number text-center" style="font-size:0.7em;">{{$dd->quantidade_vidas}}</span>
                    </div>
                </div>
            </div>

        @endforeach








    </div>







    <div class="row">
        <div class="col-12">
            <form action="" method="post" name="editar_colaborador" class="border border-white rounded p-1 bg-navy disabled">




                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Nome*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{$user->name}}">

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" value="{{$user->cpf}}">

                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Foto:</label>
                    <input type="file" class="form-control" id="image" name="image">

                </div>


                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label for="endereco">Endereco:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereco" value="{{old('endereco')}}">

                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="numero">Numero:</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="{{$user->numero}}">

                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cidade">Cidade:</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{$user->cidade}}">

                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="estado" class="control-label">Estado:</label>
                        <select id="estado" name="estado" class="form-control select2-single">
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
                        <input type="text" class="form-control" id="celular" name="celular" placeholder="(XX) X XXXXX-XXXX" value="{{$user->celular}}">

                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password">Senha:*</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha" value="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email">Email:*</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">

                    </div>



                </div>



                <div class="form-row">
                    <div class="col-8">
                        <label for="cargo">Cargo</label>
                        <div class="d-flex">
                            @foreach($cargos as $c)
                                <label for="cargo_{{$c->nome}}" class="mr-3">
                                    <input type="radio" id="cargo_{{$c->nome}}" name="cargo" value="{{$c->id}}" {{$c->id == $user->cargo_id ? 'checked' : ''}}  >{{$c->nome}}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="">Ativado/Desativado</label>
                        <select name="ativo_desativo" id="ativo_desativo" class="form-control">
                            <option value="">--Escolher--</option>
                            <option value="1" {{$user->ativo == 1 ? 'selected' : ''}}>Ativado</option>
                            <option value="0" {{$user->ativo == 0 ? 'selected' : ''}}>Desativado</option>
                        </select>
                    </div>

                </div>
                <button class="btn btn-primary btn-block mt-2 btn_primary">Editar</button>
                <input type="hidden" id="id" name="id" value="{{$user->id}}">
            </form>

        </div>









    </div>












@stop

@section('css')
    <style>
        .medal {
            width: 100px; /* Largura da medalha */
            height: 100px; /* Altura da medalha */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px; /* Tamanho da fonte do número */
            font-weight: bold; /* Pode ajustar o peso da fonte conforme necessário */
            border-radius: 50%; /* Bordas arredondadas para um visual de medalha */
            position: relative; /* Para posicionar a estrela */
        }

        .position {
            z-index: 1; /* Coloca o número acima da medalha */
        }

        .gold {
            background-color: #FFD700; /* Cor da medalha de Ouro */
            color: #000; /* Cor do número */
        }

        .silver {
            background-color: #C0C0C0; /* Cor da medalha de Prata */
            color: #000; /* Cor do número */
        }

        .bronze {
            background-color: #CD7F32; /* Cor da medalha de Bronze */
            color: #FFF; /* Cor do número */
        }
    </style>
@stop

@section('js')
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let image = ""
            $("#image").on('change',function(e){
                image = e.target.files;
            });

           $(".btn_primary").on('click',function(){
               var fd = new FormData();
               fd.append('file',image[0]);
               fd.append('nome',$('#name').val());
               fd.append('id',$('#id').val());
               fd.append('endereco',$('#endereco').val());
               fd.append('numero',$('#numero').val());
               fd.append('cidade',$('#cidade').val());
               fd.append('estado',$('#estado').val());
               fd.append('celular',$('#celular').val());
               fd.append('password',$('#password').val());
               fd.append('email',$('#email').val());
               fd.append('cargo',$('input[name="cargo"]:checked').attr('checked',true).val());
               fd.append('cpf',$("#cpf").val());
               fd.append('status',$("#ativo_desativo").val());
               $.ajax({
                   url:"{{route('corretores.edit')}}",
                   method:"POST",
                   data:fd,
                   contentType: false,
                   processData: false,
                   success:function(res){

                       $(".imagem-logo").attr("src","/storage/"+res.image);

                   }
               });



                return false;
           });
        });
    </script>
@stop
