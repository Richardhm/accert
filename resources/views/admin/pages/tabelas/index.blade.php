@extends('adminlte::page')
@section('title', 'Tabela de Preços')
@section('plugins.Toastr', true)
@section('content_header')
    <div class="d-flex">
        <div class="d-flex" style="flex-basis:90%;">
            <h1>Tabela de Preços <small style="font-size:0.6em;color:red;">(Escolher todos os campos para liberar os campos de valores)</small></h1>
        </div>
        <div class="dsnone" id="editar_coparticipacao" style="flex-basis:10%;">
            <div>
                <a href="#" class="link_coparticipacao">
                    <i class="fas fa-pen"></i>
                    <span class="ml-1">Coparticipação</span>
                </a>
            </div>
        </div>

    </div>
@stop

@section('content')
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>

    <ul class="list_abas" style="margin-top:1px;">
        <li data-id="aba_tabela" class="menu-inativo ativo">Tabelas</li>
        <li data-id="aba_coparticipacao" class="menu-inativo">Coparticipação</li>

    </ul>



    <!--Tabelas-->
    <div id="aba_tabela">

        <div id="container_alert_cadastrar" class="text-center"></div>

        <div class="card">
            <div class="card-body" id="configurar_tabelas">

                    <form action="{{route('store.tabela')}}" method="POST">
                        @csrf
                        <div class="form-row">

                            <div class="col-md-3 mb-2">
                                <label for="administradora">Administradora:</label>
                                <select name="administradora" id="administradora" class="form-control">
                                    <option value="">--Escolher a Administradora--</option>
                                    @foreach($administradoras as $aa)
                                        <option value="{{$aa->id}}" {{$aa->id == old('administradora') ? 'selected' : ''}}>{{$aa->nome}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('administradora'))
                                    <p class="alert alert-danger">{{$errors->first('administradora')}}</p>
                                @endif
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="planos">Planos:</label>
                                <select name="planos" id="planos" class="form-control">
                                    <option value="">--Escolher o Plano--</option>
                                    @foreach($planos as $pp)
                                        <option value="{{$pp->id}}" {{$pp->id == old('planos') ? 'selected' : ''}}>{{$pp->nome}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('planos'))
                                    <p class="alert alert-danger">{{$errors->first('planos')}}</p>
                                @endif
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="">Cidade:</label>
                                <select name="tabela_origem" id="tabela_origem" class="form-control">
                                    <option value="">--Escolher a Cidade--</option>
                                    @foreach($tabela_origem as $cc)
                                        <option value="{{$cc->id}}" {{$cc->id == old('tabela_origem') ? 'selected' : ''}}>{{$cc->nome}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tabela_origem'))
                                    <p class="alert alert-danger">{{$errors->first('tabela_origem')}}</p>
                                @endif
                            </div>



                            <div class="col-md-2 mb-2">
                                    <label for="coparticipacao">Coparticipação:</label><br />
                                    <select name="coparticipacao" id="coparticipacao" class="form-control">
                                        <option value="">--Escolher Coparticipacao--</option>
                                        <option value="sim" {{old('coparticipacao') == "sim" ? 'selected' : ''}}>Com Coparticipação</option>
                                        <option value="nao" {{old('coparticipacao') == "nao" ? 'selected' : ''}}>Coparticipação Parcial</option>
                                    </select>
                                    @if($errors->has('coparticipacao'))
                                        <p class="alert alert-danger">{{$errors->first('coparticipacao')}}</p>
                                    @endif
                            </div>
                            <div class="col-md-2 mb-2">
                                    <label for="odonto">Odonto:</label><br />
                                    <select name="odonto" id="odonto" class="form-control">
                                        <option value="">--Escolher Odonto--</option>
                                        <option value="sim" {{old('odonto') == "sim" ? 'selected' : ''}}>Com Odonto</option>
                                        <option value="nao" {{old('odonto') == "nao" ? 'selected' : ''}}>Sem Odonto</option>
                                    </select>
                                    @if($errors->has('odonto'))
                                        <p class="alert alert-danger">{{$errors->first('odonto')}}</p>
                                    @endif
                            </div>

                        </div>

                        <h4 class="text-center py-2 border">Valores</h4>
                        <div class="form-row">

                                <div class="col" style="border-right:2px solid black;">
                                    <div class="form-group">
                                        @foreach($faixas as $k => $f)
                                            <div>
                                                @if($loop->first)
                                                    <h6 style="font-weight:bold;text-decoration:underline;">Apartamento</h6>

                                                @endif
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="text" disabled class="" value="{{$f->nome}}" />
                                                        <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_apartamento[]" />
                                                        <input type="text" disabled placeholder="valor" name="valor_apartamento[]" value="{{isset(old('valor_apartamento')[$k]) && !empty(old('valor_apartamento')[$k]) ? old('valor_apartamento')[$k] : ''}}" />
                                                        @if($errors->any('valor_apartamento'.$k) && !empty($errors->get('valor_apartamento.'.$k)[0]))
                                                            <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="col" style="border-right:2px solid black;">
                                    <div class="form-group">
                                        @foreach($faixas as $k => $f)
                                            <div>
                                                @if($loop->first)
                                                    <h6 style="font-weight:bold;text-decoration:underline;">Enfermaria</h6>
                                                @endif
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="text" disabled class="" value="{{$f->nome}}" />
                                                        <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_enfermaria[]" />
                                                        <input type="text" disabled placeholder="valor" name="valor_enfermaria[]" value="{{isset(old('valor_enfermaria')[$k]) && !empty(old('valor_enfermaria')[$k]) ? old('valor_enfermaria')[$k] : ''}}" />
                                                        @if($errors->any('valor_enfermaria'.$k) && !empty($errors->get('valor_enfermaria.'.$k)[0]))
                                                            <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                            @foreach($faixas as $k => $f)
                                                <div>
                                                    @if($loop->first)
                                                        <h6 style="font-weight:bold;text-decoration:underline;">Ambulatorial</h6>
                                                    @endif
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="text" disabled class="" value="{{$f->nome}}" />
                                                            <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_ambulatorial[]" />
                                                            <input type="text" disabled placeholder="valor" name="valor_ambulatorial[]" value="{{isset(old('valor_ambulatorial')[$k]) && !empty(old('valor_ambulatorial')[$k]) ? old('valor_ambulatorial')[$k] : ''}}" />
                                                            @if($errors->any('valor_ambulatorial'.$k) && !empty($errors->get('valor_ambulatorial.'.$k)[0]))
                                                                <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                        </div>





                </div>


                <div id="container_btn_cadastrar">

                </div>



        </form>










    </div>




    </div>
    <!--Fim Tabelas-->

    <div id="aba_coparticipacao" class="ocultar">

        <div class="d-flex mb-2">

            <div class="d-flex w-50" style="flex-wrap:wrap;">
                <label for="plano_coparticipacao" class="w-100">Planos</label>
                <select name="plano_coparticipacao" id="plano_coparticipacao" class="form-control">
                    <option value="">--Escolher o plano--</option>
                    @foreach($planos as $p)
                        <option value="{{$p->id}}">{{$p->nome}}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex w-50" style="flex-wrap:wrap;">
                <label for="tabela_origem_coparticipacao" class="w-100">Tabela Origem</label>
                <select name="tabela_origem_coparticipacao" id="tabela_origem_coparticipacao" class="form-control">
                    <option value="">--Escolher Tabela Origem--</option>
                    @foreach($tabela_origem as $to)
                        <option value="{{$to->id}}">{{$to->nome}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div id="container_form_coparticipacao" class="ocultar" style="border:4px solid black;border-radius:5px;padding:3px;">

        <form action="{{route('tabela.store.coparticipacao')}}" method="POST">

            <input type="text" name="plano_id" value="">
            <input type="text" name="tabela_origens_id" value="">

            @csrf

            <div class="d-flex justify-content-between">

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="consulta_eletivas" style="font-size:1em;">Consultas Eletivas</label>
                    <input type="text" id="consulta_eletivas" name="consulta_eletivas" class="form-control" value="">
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="consulta_urgencia" style="font-size:1em;">Consultas de Urgência</label>
                    <input type="text" id="consulta_urgencia" name="consulta_urgencia" class="form-control" value="">
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="exames_simples" style="font-size:1em;">Exames Simples</label>
                    <input type="text" id="exames_simples" name="exames_simples" class="form-control" value="">
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="exames_complexos" style="font-size:1em;">Exames Complexos</label>
                    <input type="text" id="exames_complexos" name="exames_complexos" class="form-control" value="">
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="terapias" style="font-size:1em;">Terapias</label>
                    <input type="text" id="terapias" name="terapias" class="form-control" value="">
                </div>
            </div>

            <div class="my-4" style="border:5px solid white;"></div>

            <div class="d-flex flex-column">
                <h4 class="text-center" style="margin:0;padding:0;">Observações</h4>
                <div>
                    <label for="linha1">Linha 1</label>
                    <input type="text" id="linha1" name="linha1" class="form-control"
                    value="{{ old('linha01') !== null ? old('linha01') : ($co->linha01 ?? '') }}">

                </div>

                <div>
                    <label for="linha2">Linha 2</label>
                    <input type="text" id="linha2" name="linha2" class="form-control"
                    value="{{ old('linha02') !== null ? old('linha02') : ($co->linha02 ?? '') }}">

                </div>

                <div>
                    <label for="linha3">Linha 3</label>
                    <input type="text" id="linha3" name="linha3" class="form-control"
                    value="{{ old('linha03') !== null ? old('linha03') : ($co->linha03 ?? '') }}">

                </div>

            </div>

            <button type="submit" class="btn btn-primary btn-block mt-4">Cadastrar</button>

            </div>

        </form>




        </div>



    </div>

@stop

@section('js')
	<script src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script>
		$(function(){

            $('#consulta_eletivas').mask("#.##0,00", {reverse: true});
			$('#consulta_urgencia').mask("#.##0,00", {reverse: true});
			$('#exames_simples').mask("#.##0,00", {reverse: true});
			$('#exames_complexos').mask("#.##0,00", {reverse: true});
			$('#terapias').mask("#.##0,00", {reverse: true});

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#plano_coparticipacao, #tabela_origem_coparticipacao').change(function () {
                //Verifica se ambos os selects têm valores selecionados
                let planoSelecionado = $('#plano_coparticipacao').val();
                let tabelaOrigemSelecionada = $('#tabela_origem_coparticipacao').val();
                // Se ambos os selects tiverem valores selecionados

                if (planoSelecionado !== '' && tabelaOrigemSelecionada !== '') {
                    $("#container_form_coparticipacao").slideDown('slow').removeClass("ocultar");

                    $("input[name='plano_id']").val(planoSelecionado);
                    $("input[name='tabela_origens_id']").val(tabelaOrigemSelecionada);



                    // Coloque aqui a lógica que você deseja executar quando ambos os selects estiverem preenchidos.
                } else {
                    $("#container_form_coparticipacao").slideUp('slow').addClass("ocultar");
                }
            });









            $(".list_abas li").on('click',function(){
                $('.list_abas li')
                    .removeClass('ativo')
                    .addClass('menu-inativo');

                $(this)
                    .addClass("ativo");
                    let id = $(this).attr('data-id');
                    //$('.conteudo_abas main').addClass('ocultar');
                    //$('#'+id).removeClass('ocultar');



                if(id == "aba_coparticipacao") {
                    $("#aba_coparticipacao").removeClass('ocultar');
                    $("#aba_tabela").addClass('ocultar');
                }

                if(id == "aba_tabela") {
                    $("#aba_tabela").removeClass('ocultar');
                    $("#aba_coparticipacao").addClass('ocultar');
                }

            });


            $('body').on('change','.valor',function(){
                let valor = $(this).val();
                let id = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('corretora.mudar.valor.tabela')}}",
                    method:"POST",
                    data:"id="+id+"&valor="+valor,
                    success:function(res) {
                        console.log(res);
                    }
                });
            });


            $("#administradora").on('change',function(){
                let administradora = $(this).val();
                $.ajax({
                    url:"{{route('planos.administradora.select')}}",
                    method:"POST",
                    data:"administradora="+administradora,
                    success:function(res) {
                        $('#planos').empty();
                        $('#planos').append('<option value="">--Escolher o Plano--</option>');
                        // Adicionar as opções do objeto
                        $.each(res, function (index, value) {
                            $('#planos').append('<option value="' + value.id + '">' + value.nome + '</option>');
                        });
                    }
                });
            });




            function verificarCampos() {
                $('select').each(function() {
                    if ($('select[name="administradora"]').val() == '' ||
                        $('select[name="planos"]').val() == '' ||
                        $('select[name="tabela_origem"]').val() == '' ||
                        $('select[name="coparticipacao"]').val() == '' ||
                        $('select[name="odonto"]').val() == '') {
                            return false;
                    } else {
                        $('input[name="valor_apartamento[]"]').removeAttr('disabled');
                        $('input[name="valor_enfermaria[]"]').removeAttr('disabled');
                        $('input[name="valor_ambulatorial[]"]').removeAttr('disabled');

                        let plano = $("#planos").val();
                        let cidade = $("#tabela_origem").val();
                        //$('.link_coparticipacao').attr('href',`/admin/tabela/coparticipacao/${plano}/${cidade}`);

                    }
                });
            }
            verificarCampos();


			$('input[name*="valor_apartamento"]').mask("#.##0,00", {reverse: true});
			$('input[name*="valor_enfermaria"]').mask("#.##0,00", {reverse: true});
			$('input[name*="valor_ambulatorial"]').mask("#.##0,00", {reverse: true});

            var valores = [];
            $('select').change(function() {
                // Verificar se todos os selects têm uma opção selecionada
                let todosPreenchidos = true;



                if ($('select[name="administradora"]').val() == '' ||
                        $('select[name="planos"]').val() == '' ||
                        $('select[name="tabela_origem"]').val() == '' ||
                        $('select[name="coparticipacao"]').val() == '' ||
                        $('select[name="odonto"]').val() == '')
                {
                    todosPreenchidos = false;
                    return false;
                } else {

                    var valores = {
                        "administradora" : $('select[name="administradora"]').val(),
                        "planos" : $('select[name="planos"]').val(),
                        "tabela_origem" : $('select[name="tabela_origem"]').val(),
                        "coparticipacao" : $('select[name="coparticipacao"]').val(),
                        "odonto" : $('select[name="odonto"]').val()
                    };
                    //valores.push($(this).val());
                    $(".alert-danger").remove();
                }


                if (todosPreenchidos) {

                    $('input[name*="valor_apartamento"]').prop('disabled',false);
                    $('input[name*="valor_enfermaria"]').prop('disabled',false);
                    $('input[name*="valor_ambulatorial"]').prop('disabled',false);

                    let plano = $("#planos").val();
                    let cidade = $("#tabela_origem").val();
                    $('.valor').removeAttr('disabled');
                    //$('.link_coparticipacao').attr('href',`/admin/tabela/coparticipacao/${plano}/${cidade}`);
                    //$("#editar_coparticipacao").removeClass('dsnone').addClass('d-flex');
                    $("#accordionExample").removeClass('dsnone');
                    $.ajax({
                        url:"{{route('verificar.valores.tabela')}}",
                        method:"POST",
                        data: {
                            "administradora" : $('select[name="administradora"]').val(),
                            "planos" : $('select[name="planos"]').val(),
                            "tabela_origem" : $('select[name="tabela_origem"]').val(),
                            "coparticipacao" : $('select[name="coparticipacao"]').val(),
                            "odonto" : $('select[name="odonto"]').val(),

                        },
                        success:function(res) {

                            if(res != "empty") {

                                $('input[name="valor_apartamento[]"]').each(function(index) {
                                    $(this).addClass('valor');
                                    if (res[index] && res[index].acomodacao_id == 1) {
                                        $(this).val(res[index].valor_formatado).attr('data-id',res[index].id);
                                    }
                                });
                                $('input[name="valor_enfermaria[]"]').each(function(index) {
                                    $(this).addClass('valor');
                                    if (res[index+10] && res[index+10].acomodacao_id == 2) {
                                        $(this).val(res[index+10].valor_formatado).attr('data-id',res[index+10].id);
                                    }
                                });
                                $('input[name="valor_ambulatorial[]"]').each(function(index) {
                                    $(this).addClass('valor');
                                    if (res[index+20] && res[index+20].acomodacao_id == 3) {
                                        $(this).val(res[index+20].valor_formatado).attr('data-id',res[index+20].id)
                                    }
                                });
                                $("#container_btn_cadastrar").slideUp('slow').html('');
                            } else {
                                $('input[name="valor_apartamento[]"]')
                                    .val('')
                                    .removeClass('valor');

                                $('input[name="valor_enfermaria[]"]')
                                    .val('')
                                    .removeClass('valor');

                                $('input[name="valor_ambulatorial[]"]')
                                    .val('')
                                    .removeClass('valor');

                                $("#container_btn_cadastrar")
                                    .html(`<button class='btn btn-block btn-info btn_cadastrar'>Cadastrar</button>`)
                                    .hide()
                                    .slideDown('slow');

                                $("#container_alert_cadastrar")
                                    .html(`<h4 class="alert alert-info">Essa tabela não existe, para inserir os dados clicar no botão cadastrar abaixo.</h4>`)
                                    .hide()
                                    .slideDown('slow');
                            }
                        }
                    });





                } else {

                    $("#editar_coparticipacao").removeClass('d-flex').addClass('dsnone');
                    $('input[name="valor_apartamento[]"]').val('');
                    $('input[name="valor_enfermaria[]"]').val('');
                    $('input[name="valor_ambulatorial[]"]').val('');
                }
            });

            $("body").on('click','.btn_cadastrar',function(){

                let load = $(".ajax_load");
                let camposApartamentoPreenchidos  = verificarCamposPreenchidos("valor_apartamento[]");
                let camposEnfermariaPreenchidos   = verificarCamposPreenchidos("valor_enfermaria[]");
                let camposAmbulatorialPreenchidos = verificarCamposPreenchidos("valor_ambulatorial[]");

                if (camposApartamentoPreenchidos && camposEnfermariaPreenchidos && camposAmbulatorialPreenchidos) {

                    let valoresApartamento = obterValoresDosCampos("valor_apartamento[]");
                    let valoresEnfermaria = obterValoresDosCampos("valor_enfermaria[]");
                    let valoresAmbulatorial = obterValoresDosCampos("valor_ambulatorial[]");

                    // Preparar os dados para enviar ao backend (você pode ajustar de acordo com suas necessidades)
                    let dados = {
                        valoresApartamento: valoresApartamento,
                        valoresEnfermaria: valoresEnfermaria,
                        valoresAmbulatorial: valoresAmbulatorial,
                        administradora : $('select[name="administradora"]').val(),
                        planos : $('select[name="planos"]').val(),
                        tabela_origem : $('select[name="tabela_origem"]').val(),
                        coparticipacao : $('select[name="coparticipacao"]').val(),
                        odonto : $('select[name="odonto"]').val(),
                    };

                    $.ajax({
                        url:"{{route('cadastrar.valores.tabela')}}",
                        method:"POST",
                        data:dados,
                        beforeSend: function () {
                            load.fadeIn(100).css("display", "flex");
                        },
                        success:function(res) {
                            if(res == "sucesso") {
                                load.fadeOut(300);
                                toastr["success"]("Tabela cadastrada com sucesso")
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
                                $("#container_btn_cadastrar").html('');
                                $("#container_alert_cadastrar").html('');





                            } else {
                                toastr["error"]("Erro ao cadastrar a tabela")
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

                            }
                        }
                    });


                } else {

                    toastr["error"]("Todos os campos são obrigatório")
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
                    return false; // Impede o envio do formulário se algum campo estiver em branco




                }









                return false; // Isso impede o envio do formulário para evitar que a página seja recarregada
            });

            function verificarCamposPreenchidos(tipoCampo) {
                var todosPreenchidos = true;
                $("input[name='" + tipoCampo + "']").each(function () {
                    if ($(this).val() === "") {
                        todosPreenchidos = false;
                        return false; // Encerra o loop se encontrar um campo não preenchido
                    }
                });
                return todosPreenchidos;
            }

            // Função para obter os valores dos campos de um determinado tipo
            function obterValoresDosCampos(tipoCampo) {
                var valores = [];
                $("input[name='" + tipoCampo + "']").each(function () {
                    valores.push($(this).val());
                });
                return valores;
            }








		});
	</script>

@stop

@section('css')
    <style>
        .dsnone {display:none;}
        .ocultar {display: none;}
        .ajax_load {display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;}
        .ajax_load_box{margin:auto;text-align:center;color:#fff;font-weight:var(700);text-shadow:1px 1px 1px rgba(0,0,0,.5)}
        .ajax_load_box_circle{border:16px solid #e3e3e3;border-top:16px solid #61DDBC;border-radius:50%;margin:auto;width:80px;height:80px;-webkit-animation:spin 1.2s linear infinite;-o-animation:spin 1.2s linear infinite;animation:spin 1.2s linear infinite}
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}

        .list_abas {list-style: none;display: flex;border-bottom: 1px solid white;margin: 0;padding: 0;}
        .list_abas li {color: #fff;width: 150px;padding: 8px 5px;text-align:center;border-radius: 5px 5px 0 0;background-color:#123449;}
        .list_abas li:hover {cursor: pointer;}
        .list_abas li:nth-of-type(2) {margin: 0 1%;}
        .ativo {background-color:#FFF !important;color: #000 !important;}


    </style>
@stop
