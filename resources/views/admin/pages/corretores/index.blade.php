@extends('adminlte::page')
@section('title', 'Corretora')
@section('plugins.Datatables', true)
@section('plugins.Toastr', true)
@section('content_header')
	<h3 class="text-white">
		<button class="estilo_btn_plus">
			<i class="fas fa-plus"></i>
		</button>
	</h3>
@stop

@section('content')
	<!--Modal-->
	<div class="modal fade" id="cadastrarAdministradora" tabindex="-1" role="dialog" aria-labelledby="cadastrarAdministradoraTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cadastrarAdministradoraTitle">Cadastrar Colaborador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" name="cadastrar_colaborador" enctype="multipart/form-data" autocomplete="off">
            @csrf


            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{old('name')}}">
                    @if($errors->has('name'))
                        <p class="alert alert-danger">{{$errors->first('name')}}</p>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" value="{{old('cpf')}}">
                    @if($errors->has('cpf'))
                        <p class="alert alert-danger">{{$errors->first('cpf')}}</p>
                    @endif
                    @if(session('errorcpf'))
                        <p class="alert alert-danger">{{ session('errorcpf') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="image">Foto:</label>
                <input type="file" class="form-control" id="image" name="image">

            </div>


            <div class="form-row">
                <div class="col-md-9 mb-3">
                    <label for="endereco">Endereco:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereco" value="{{old('endereco')}}">
                    @if($errors->has('endereco'))
                        <p class="alert alert-danger">{{$errors->first('endereco')}}</p>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label for="numero">Numero:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero" value="{{old('numero')}}">
                    @if($errors->has('numero'))
                        <p class="alert alert-danger">{{$errors->first('numero')}}</p>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="cidade">Cidade:</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{old('cidade')}}">
                    @if($errors->has('cidade'))
                        <p class="alert alert-danger">{{$errors->first('cidade')}}</p>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label for="estado" class="control-label">Estado:</label>
                    <select id="estado" name="estado" class="form-control select2-single">
                        <option value="">Escolha o estado</option>
                        <option value="AC" {{old('estado') == "AC" ? 'selected' : ''}}>Acre</option>
                        <option value="AL" {{old('estado') == "AL" ? 'selected' : ''}}>Alagoas</option>
                        <option value="AP" {{old('estado') == "AP" ? 'selected' : ''}}>Amapá</option>
                        <option value="AM" {{old('estado') == "AM" ? 'selected' : ''}}>Amazonas</option>
                        <option value="BA" {{old('estado') == "BA" ? 'selected' : ''}}>Bahia</option>
                        <option value="CE" {{old('estado') == "CE" ? 'selected' : ''}}>Ceará</option>
                        <option value="DF" {{old('estado') == "DF" ? 'selected' : ''}}>Distrito Federal</option>
                        <option value="ES" {{old('estado') == "ES" ? 'selected' : ''}}>Espírito Santo</option>
                        <option value="GO" {{old('estado') == "GO" ? 'selected' : ''}}>Goiás</option>
                        <option value="MA" {{old('estado') == "MA" ? 'selected' : ''}}>Maranhão</option>
                        <option value="MT" {{old('estado') == "MT" ? 'selected' : ''}}>Mato Grosso</option>
                        <option value="MS" {{old('estado') == "MS" ? 'selected' : ''}}>Mato Grosso do Sul</option>
                        <option value="MG" {{old('estado') == "MG" ? 'selected' : ''}}>Minas Gerais</option>
                        <option value="PA" {{old('estado') == "PA" ? 'selected' : ''}}>Pará</option>
                        <option value="PB" {{old('estado') == "PB" ? 'selected' : ''}}>Paraíba</option>
                        <option value="PR" {{old('estado') == "PR" ? 'selected' : ''}}>Paraná</option>
                        <option value="PE" {{old('estado') == "PE" ? 'selected' : ''}}>Pernambuco</option>
                        <option value="PI" {{old('estado') == "PI" ? 'selected' : ''}}>Piauí</option>
                        <option value="RJ" {{old('estado') == "RJ" ? 'selected' : ''}}>Rio de Janeiro</option>
                        <option value="RN" {{old('estado') == "RN" ? 'selected' : ''}}>Rio Grande do Norte</option>
                        <option value="RS" {{old('estado') == "RS" ? 'selected' : ''}}>Rio Grande do Sul</option>
                        <option value="RO" {{old('estado') == "RO" ? 'selected' : ''}}>Rondônia</option>
                        <option value="RR" {{old('estado') == "RR" ? 'selected' : ''}}>Roraima</option>
                        <option value="SC" {{old('estado') == "SC" ? 'selected' : ''}}>Santa Catarina</option>
                        <option value="SP" {{old('estado') == "SP" ? 'selected' : ''}}>São Paulo</option>
                        <option value="SE" {{old('estado') == "SE" ? 'selected' : ''}}>Sergipe</option>
                        <option value="TO" {{old('estado') == "TO" ? 'selected' : ''}}>Tocantins</option>
                    </select>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="celular">Celular:</label>
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="(XX) X XXXXX-XXXX" value="{{old('celular')}}">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="password">Senha:*</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha" autocomplete="new-password">

                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email:*</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">

                </div>
            </div>

            <div class="d-flex justify-content-between">
                    <div class="w-25">
                        <label for="cargo">Cargo</label>
                        <div class="d-flex">
                            <select name="cargo" id="cargo" class="form-control">
                            <option value="">--Escolher--</option>
                            @foreach($cargos as $c)
                                <option id="cargo_{{$c->nome}}" name="cargo_{{$c->nome}}" value="{{$c->id}}">{{$c->nome}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-25">

                         <label for="tipo">Tipo</label>
                        <div class="d-flex">
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="">--Escolher--</option>
                                <option id="tipo_clt" name="tipo_clt" value="1">CLT</option>
                                <option id="tipo_parceiro" name="tipo_parceiro" value="2">Parceiro</option>

                            </select>
                        </div>



                    </div>

                    <div class="w-25">
                        <label for="">Ativado/Desativado</label>
                        <select name="ativo_desativo" id="ativo_desativo" class="form-control">
                            <option value="">--Escolher--</option>
                            <option value="1">Ativado</option>
                            <option value="0">Desativado</option>
                        </select>
                    </div>

                </div>
            <button class="btn btn-primary btn-block" type="submit">Cadastrar</button>
           </form>
      </div>
    </div>
  </div>
</div>
	<!--Fim Modal-->




    <div style="display:flex;flex-basis:100%;">
        <div style="display:flex;flex-basis:25%;">

            <div id="list_user" class="w-100 rounded p-1 text-white">
                <table class="table table-sm listar_user" id="listar_usuarios">
                    <thead>
                        <tr>
                            <th style="font-size:0.7em;">Nome</th>
                            <!-- <th style="text-align:center;">Editar</th> -->
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>





        </div>
        <div style="display:flex;flex-basis:72%;margin-left:1%;" id="content_user"></div>
    </div>
@stop


@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script>
		$(function(){

            $('#celular').mask('(00) 0 0000-0000');
            $('#cpf').mask('000.000.000-00');


			$(".estilo_btn_plus").on('click',function(){
				$('#cadastrarAdministradora').modal('show')
			});

			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var tauser = $(".listar_user").DataTable({
                dom: '<"d-flex justify-content-between"<"#title_individual"><f><"d-flex justify-content-between">',
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                processing: true,
                ajax: {
                    "url":"{{ route('corretores.list') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [10000],
                "ordering": false,
                "paging": false,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {data:"name",name:"name"},
                    // {data:"id",name:"id"}

                ],
                "columnDefs": [
                    {
                        "targets": 0, // Índice da coluna que deseja estilizar (0 é a primeira coluna)
                        "createdCell": function (td, cellData, rowData, row, col) {
                            // Aplica o estilo de fonte menor para a primeira coluna
                            if (col === 0) {
                                $(td).attr('data-id',rowData.id).css('font-size', '0.7em');
                            }

                            // Adicione outros estilos ou verificações conforme necessário
                        }
                    },

                    // {

                    //     "targets": 1,
                    //     "createdCell": function (td, cellData, rowData, row, col) {
                    //         let id = cellData
                    //         $(td).html(`<div class='text-center text-white'>
                    //                     <a href="/admin/corretotes/editar/${id}" class="text-white">
                    //                         <i class='fas fa-eye div_info'></i>
                    //                     </a>
                    //                 </div>
                    //             `);
                    //     }
                    // }





                ],
                "initComplete": function( settings, json ) {
                    $('.dataTables_filter input').addClass('texto-branco');


                },
                "drawCallback": function( settings ) {

                },

                footerCallback: function (row, data, start, end, display) {

                }
            });

            $('.listar_user tbody').on('click', 'tr', function() {
                let id = tauser.row(this).data().id;
                $.ajax({
                    url:"{{route('corretores.editar')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        $("#content_user").html(res);
                    }
                });

            });

            let image = ""
            $("#image").on('change',function(e){
            	image = e.target.files;
            });

			$("form[name='cadastrar_colaborador']").on('submit',function(e){
            	let fd = new FormData();
		        fd.append('file',image[0]);
		        fd.append('nome',$('#name').val());
		        fd.append('endereco',$('#endereco').val());
		        fd.append('numero',$('#numero').val());
		        fd.append('cidade',$('#cidade').val());
		        fd.append('estado',$('#estado').val());
		        fd.append('celular',$('#celular').val());
		        fd.append('password',$('#password').val());
		        fd.append('email',$('#email').val());
		        fd.append('cargo',$('input[name="cargo"]:checked').attr('checked',true).val());
                fd.append('cpf',$("#cpf").val());

                fd.append('cargo',$("#cargo").val());
                fd.append('tipo',$("#tipo").val());
                fd.append('ativo_desativo',$("#ativo_desativo").val());


            	$.ajax({
            		url:"{{route('corretores.store')}}",
            		method:"POST",
            		data:fd,
            		contentType: false,
           			processData: false,

                    beforeSend:function() {
                        if($("#name").val() == "") {
                            toastr["error"]("Preencher o campo nome")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($("#celular").val() == "") {
                            toastr["error"]("Preencher o campo celular")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                        if($("#password").val() == "" || $("#password").val().length < 8) {
                            toastr["error"]("Senha não pode ser vazio e deve ter no minimo 8 caracteres")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                        if($("#email").val() == "") {
                            toastr["error"]("Preencher o campo email")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($("#cargo").val() == "") {
                            toastr["error"]("Preencher o campo cargo")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($("#tipo").val() == "") {
                            toastr["error"]("Preencher o campo tipo")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($("#ativo_desativo").val() == "") {
                            toastr["error"]("Preencher o campo ativo/desativo")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }






                    },
               		success:function(res){
            			console.log(res);
            			if(res == "sucesso") {
            				$('#cadastrarAdministradora').modal('hide');
            				tauser.ajax.reload();
            			} else {

            			}
            		}
            	});
            	return false;
            });


            let image_edit = "";

            $("body").on('change','#image_editar',function(e){
                image_edit = e.target.files;
                let newImage = e.target.files[0];
                let reader = new FileReader();
                reader.onload = function (e) {
                    // Atualiza o atributo src com a nova imagem
                    $("#userImage").attr("src", e.target.result);
                };
                reader.readAsDataURL(newImage);
            });

            $("body").on('submit','form[name="editar_colaborador"]',function(e){
                e.preventDefault();
                console.log("Olaaaaaaaaaaaaaaaa");
                return false;
            });



            // $("body").on('click','.editar_user',function(e){
            //     e.preventDefault();
            //     let fd = new FormData();
		    //     fd.append('file',image_edit[0]);
		    //     fd.append('nome',$('#name_editar').val());
		    //     fd.append('endereco',$('#endereco_editar').val());
		    //     fd.append('numero',$('#numero_editar').val());
		    //     fd.append('cidade',$('#cidade_editar').val());
		    //     fd.append('estado',$('#estado_editar').val());
		    //     fd.append('celular',$('#celular_editar').val());
		    //     fd.append('password',$('#password_editar').val());
		    //     fd.append('email',$('#email_editar').val());

            //     fd.append('cpf',$("#cpf_editar").val());

            //     fd.append('cargo',$("#cargo_editar").val());
            //     fd.append('id',$("#id").val());
            //     fd.append('tipo',$("#tipo_editar").val());
            //     fd.append('ativo_desativo',$("#ativo_desativo_editar").val());
            //     console.log(fd);
            //     // $.ajax({
            //     //     url:"{{route('corretores.edit')}}",
            //     //     method:"POST",
            //     //     data:fd,
            // 	// 	contentType: false,
           	// 	// 	processData: false,
            //     //     success:function(res) {
            //     //         console.log(res);
            //     //     }
            //     // });



            //     return false;
            // });
		});
	</script>
@stop

@section('css')
    <style>
        .estilo_btn_plus {background-color:rgba(0,0,0,1);box-shadow:rgba(255,255,255,0.8) 0.1em 0.2em 5px;border-radius: 5px;display: flex;align-items: center;}
        .estilo_btn_plus i {color: #FFF !important;font-size: 0.7em;padding: 8px;}
        .estilo_btn_plus:hover {background-color:rgba(255,255,255,0.8);box-shadow:rgba(0,0,0,1) 0.1em 0.2em 5px;}
        .estilo_btn_plus:hover i {color: #000 !important;}
        .texto-branco {color: #fff;}
        .dataTables_filter {text-align: center;}
        .dataTables_filter label {display: flex;justify-content: center;}
        .dataTables_filter input {color:black !important;}
        #list_user {background-color:#123449;margin:0 auto;height: 825px; overflow: auto;}
        #list_user::-webkit-scrollbar,#list_user_historico::-webkit-scrollbar {width: 2px;height: 2px !important;background-color: white;}
        #list_user::-webkit-scrollbar-thumb,#list_user_historico::-webkit-scrollbar-thumb {background-color: #1a88ff;}
    </style>
@stop
