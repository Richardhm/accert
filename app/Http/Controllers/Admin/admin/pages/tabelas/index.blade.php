@extends('adminlte::page')
@section('title', 'Tabela de Preços')
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

    @if(session('success'))
        <div class="alert alert-danger text-center">
            {{ session('success') }}
        </div>
    @endif
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
                                            <input type="text" disabled class="valor" placeholder="valor" name="valor_apartamento[]" value="{{isset(old('valor_apartamento')[$k]) && !empty(old('valor_apartamento')[$k]) ? old('valor_apartamento')[$k] : ''}}" />
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
                                            <input type="text" disabled class="valor" placeholder="valor" name="valor_enfermaria[]" value="{{isset(old('valor_enfermaria')[$k]) && !empty(old('valor_enfermaria')[$k]) ? old('valor_enfermaria')[$k] : ''}}" />
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
                                                <input type="text" disabled class="valor" placeholder="valor" name="valor_ambulatorial[]" value="{{isset(old('valor_ambulatorial')[$k]) && !empty(old('valor_ambulatorial')[$k]) ? old('valor_ambulatorial')[$k] : ''}}" />
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

    

    


    </form>         






</div>







@stop

@section('js')
	<script src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script>
		$(function(){
			
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".valor").on('change',function(){
                let valor = $(this).val();
                let id = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('corretora.mudar.valor.tabela')}}",
                    method:"POST",
                    data:"id="+id+"&valor="+valor,
                    success:function(res) {
                        console.log(res);
                    }
                })
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
                        $('.link_coparticipacao').attr('href',`/admin/tabela/coparticipacao/${plano}/${cidade}`);

                    }
                });
            }
            verificarCampos();


			$('.valor').mask("#.##0,00", {reverse: true});
			

            

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
                    
                    let plano = $("#planos").val();
                    let cidade = $("#tabela_origem").val();
                    $('.valor').removeAttr('disabled');
                    $('.link_coparticipacao').attr('href',`/admin/tabela/coparticipacao/${plano}/${cidade}`);
                    $("#editar_coparticipacao").removeClass('dsnone').addClass('d-flex');
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
                            console.log(res);
                            if(res != "empty") {
                                $('input[name="valor_apartamento[]"]').each(function(index) {
                                    if (res[index] && res[index].acomodacao_id == 1) {
                                        $(this).val(res[index].valor_formatado).attr('data-id',res[index].id);
                                    }
                                });
                                $('input[name="valor_enfermaria[]"]').each(function(index) {
                                    if (res[index+10] && res[index+10].acomodacao_id == 2) {
                                        $(this).val(res[index+10].valor_formatado).attr('data-id',res[index+10].id);
                                    }
                                });
                                $('input[name="valor_ambulatorial[]"]').each(function(index) {
                                    if (res[index+20] && res[index+20].acomodacao_id == 3) {
                                        $(this).val(res[index+20].valor_formatado).attr('data-id',res[index+20].id)
                                    }
                                });
                            } else {
                                $('input[name="valor_apartamento[]"]').val('');
                                $('input[name="valor_enfermaria[]"]').val('');
                                $('input[name="valor_ambulatorial[]"]').val(''); 
                            }
                        }
                    });





                } else {
                    $('.valor').prop('disabled',true);
                    $("#editar_coparticipacao").removeClass('d-flex').addClass('dsnone');                   
                    $('input[name="valor_apartamento[]"]').val('');
                    $('input[name="valor_enfermaria[]"]').val('');
                    $('input[name="valor_ambulatorial[]"]').val('');
                }
            });





		});
	</script>

@stop

@section('css')
    <style>
        .dsnone {display:none;}
    </style>    
@stop
