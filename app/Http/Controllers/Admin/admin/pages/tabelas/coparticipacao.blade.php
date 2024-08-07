@extends('adminlte::page')
@section('title', 'Tabela de Preços')
@section('content')

    <div>
        <p>Coparticipação para o plano <b>{{$plano}}</b> e cidade <b>{{$cidade}}</b></p>
    </div>



    <div style="background-color:#123449;border-radius:5px;padding:5px;border:5px solid black;margin-top:20px;">

   
    <form action="{{route('tabela.store.coparticipacao')}}" method="POST">

        <input type="hidden" name="plano_id" value="{{$plano_id}}">
        <input type="hidden" name="tabela_origens_id" value="{{$tabela_origens_id}}">


        @csrf

        <h4 class="text-center text-white">Copartipação</h4>

            <div class="d-flex justify-content-between">
            
                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="consulta_eletivas" style="font-size:1em;color:#FFF;">Consultas Eletivas</label>
                    <input type="text" id="consulta_eletivas" name="consulta_eletivas" class="form-control" 
                    value="{{ old('consulta_eletivas') !== null ? old('consulta_eletivas') : ($co->consultas_eletivas ?? '') }}">
                    @if($errors->has('consulta_eletivas'))
                        <p class="alert alert-danger" style="font-size:0.8em;">{{$errors->first('consulta_eletivas')}}</p>
                    @endif
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="consulta_urgencia" style="font-size:1em;color:#FFF;">Consultas de Urgência</label>
                    <input type="text" id="consulta_urgencia" name="consulta_urgencia" class="form-control" 
                    value="{{ old('consulta_urgencia') !== null ? old('consulta_urgencia') : ($co->consultas_urgencia ?? '') }}">
                    @if($errors->has('consulta_urgencia'))
                        <p class="alert alert-danger" style="font-size:0.8em;">{{$errors->first('consulta_urgencia')}}</p>
                    @endif
                </div>
            
                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="exames_simples" style="font-size:1em;color:#FFF;">Exames Simples</label>
                    <input type="text" id="exames_simples" name="exames_simples" class="form-control" 
                    value="{{ old('exames_simples') !== null ? old('exames_simples') : ($co->exames_simples ?? '') }}">
                    @if($errors->has('exames_simples'))
                        <p class="alert alert-danger" style="font-size:0.8em;">{{$errors->first('exames_simples')}}</p>
                    @endif
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="exames_complexos" style="font-size:1em;color:#FFF;">Exames Complexos</label>
                    <input type="text" id="exames_complexos" name="exames_complexos" class="form-control" 
                    value="{{ old('exames_complexos') !== null ? old('exames_complexos') : ($co->exames_complexos ?? '') }}">
                    @if($errors->has('exames_complexos'))
                        <p class="alert alert-danger" style="font-size:0.8em;">{{$errors->first('exames_complexos')}}</p>
                    @endif
                </div>

                <div class="d-flex" style="flex-basis:18%;flex-direction:column;">
                    <label for="terapias" style="font-size:1em;color:#FFF;">Terapias</label>
                    <input type="text" id="terapias" name="terapias" class="form-control" 
                    value="{{ old('terapias') !== null ? old('terapias') : ($co->terapias ?? '') }}">
                    @if($errors->has('terapias'))
                        <p class="alert alert-danger" style="font-size:0.8em;">{{$errors->first('terapias')}}</p>
                    @endif
                </div>
            </div>    

            <div class="my-4" style="border:5px solid white;"></div>

            <div class="d-flex flex-column">
                <h4 class="text-center text-white" style="margin:0;padding:0;">Observações</h4>
                <div>
                    <label for="linha1" style="color:#FFF;">Linha 1</label>
                    <input type="text" id="linha1" name="linha1" class="form-control" 
                    value="{{ old('linha01') !== null ? old('linha01') : ($co->linha01 ?? '') }}">
                    @if($errors->has('linha1'))
                        <p class="alert alert-danger">{{$errors->first('linha1')}}</p>
                    @endif
                </div>

                <div>
                    <label for="linha2" style="color:#FFF;">Linha 2</label>
                    <input type="text" id="linha2" name="linha2" class="form-control" 
                    value="{{ old('linha02') !== null ? old('linha02') : ($co->linha02 ?? '') }}">
                    @if($errors->has('linha2'))
                        <p class="alert alert-danger">{{$errors->first('linha2')}}</p>
                    @endif
                </div>

                <div>
                    <label for="linha3" style="color:#FFF;">Linha 3</label>
                    <input type="text" id="linha3" name="linha3" class="form-control" 
                    value="{{ old('linha03') !== null ? old('linha03') : ($co->linha03 ?? '') }}">
                    @if($errors->has('linha3'))
                        <p class="alert alert-danger">{{$errors->first('linha03')}}</p>
                    @endif
                </div>

            </div>
        
            <button type="submit" class="btn btn-primary btn-block mt-4">Cadastrar</button>

        </div>

    </form>

    @if(session('success'))
        <div class="alert alert-success text-center mt-2">
            {{ session('success') }}
        </div>
    @endif


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
        });
    </script>    
@stop
