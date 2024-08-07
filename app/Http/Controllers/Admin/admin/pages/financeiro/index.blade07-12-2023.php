@extends('adminlte::page')
@section('title', 'Financeiro')
@section('plugins.Sweetalert2',true)
@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('content_top_nav_right')
    <li class="bg-white rounded" style="padding:1px;">
        <a class="text-white nav-link" href="{{route('orcamento.search.home')}}">Tabela de Preço</a>
    </li>
    <li class="bg-white rounded" style="padding:1px;">
        <a class="text-white nav-link" href="{{route('home.administrador.consultar')}}">Consultar</a>
    </li>
    <li>
        <a class="toda_janela nav-link" data-widget="fullscreen" href="#" role="button"><i class="fas fa-expand-arrows-alt text-white"></i></a>
    </li>
@stop


@section('content')
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>
    <input type="hidden" id="janela_atual" value="aba_individual">
    <input type="hidden" id="corretor_selecionado_id" name="corretor_selecionado_id">
    <div id="container_mostrar_comissao" class="ocultar"></div>
    <input type="hidden" id="janela_ativa" name="janela_ativa" value="aba_individual">
    <div class="container_div_info"></div>
    <div class="modal fade" id="carteirinhaModal" tabindex="-1" aria-labelledby="carteirinhaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carteirinhaModalLabel">Carteirinha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="colocar_carteirinha" id="colocar_carteirinha">
                        @csrf
                        <div class="d-flex">
                            <div style="flex-basis:100%;margin-right:2%;margin-bottom:10px;">
                                <label for="arquivo">Carteirinha:</label>
                                <input type="text" name="cateirinha" id="cateirinha" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div id="carteirinha_error"></div>


                        <input type="hidden" name="id_cliente" id="carteirinha_id_input" />
                        <input type="submit" value="Enviar" class="btn btn-block btn-info">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="formulario_upload" id="formulario_upload" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <label for="arquivo">Arquivo:</label>
                                <input type="file" name="arquivo_upload" id="arquivo_upload" class="form-control form-control-sm">
                            </div>
                            <div class="btn btn-danger d-flex align-self-end div_icone_arquivo_upload" style="flex-basis:5%;">
                                <i class="fas fa-window-close fa-lg"></i>
                            </div>
                        </div>

                        <div class="d-flex my-2">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <button class="btn btn-warning btn-sm btn-block atualizar_dados text-white">Atualizar Dados</button>
                            </div>
                            <div class="btn btn-danger d-flex align-self-end div_icone_atualizar_dados">
                                <i class="fas fa-window-close fa-lg"></i>
                            </div>

                        </div>

                        <div class="d-flex my-2">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <button class="btn btn-info btn-sm btn-block sincronizar_baixas">Sincronizar Baixas</button>
                            </div>
                            <div class="btn btn-danger d-flex align-self-end">
                                <i class="fas fa-window-close fa-lg"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="uploadModalColetivo" tabindex="-1" aria-labelledby="uploadModalLabelColetivo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabelColetivo">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="formulario_upload_coletivo" id="formulario_upload_coletivo" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <label for="arquivo">Arquivo:</label>
                                <input type="file" name="arquivo_upload_coletivo" id="arquivo_upload_coletivo" class="form-control form-control-sm">
                            </div>
                            <div class="btn btn-danger d-flex align-self-end div_icone_arquivo_upload" style="flex-basis:5%;">
                                <i class="fas fa-window-close fa-lg"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dataBaixaIndividualModal" tabindex="-1" role="dialog" aria-labelledby="dataBaixaIndividualLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataBaixaIndividualLabel">Data Da Baixa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" name="data_da_baixa_individual" id="data_da_baixa_individual" method="POST">
                        <input type="date" name="date_baixa_individual" id="date_baixa_individual" class="form-control form-control-sm">
                        <input type="hidden" name="comissao_id_baixa_individual" id="comissao_id_baixa_individual">
                        <div id="error_data_baixa_individual">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div>
        <ul class="list_abas">
            <li data-id="aba_individual" class="ativo">Individual</li>
            <li data-id="aba_coletivo">Coletivo</li>
            <li data-id="aba_empresarial">Empresarial</li>
            <!-- <li data-id="aba_sem_carteirinha">Sem Carteirinha</li>   -->
        </ul>
    </div>

    {{--    <input type="text" id="campoPesquisa" placeholder="Pesquisar">--}}

    <section class="conteudo_abas">
        <!--------------------------------------INDIVIDUAL------------------------------------------>
        <main id="aba_individual">

            <section class="d-flex justify-content-between" style="flex-wrap: wrap;align-content: flex-start;">

                <!--COLUNA DA ESQUERDA-->
                <div class="d-flex flex-column text-white" style="flex-basis:16%;border-radius:5px;">

                    <div class="d-flex justify-content-between mb-1">
                        <a class="btn btn-block btn-info" href="{{route('contratos.create')}}" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:100%;">Cadastrar</a>
                    </div>


                    <div class="d-flex justify-content-between mb-1">
                        <span class="btn btn-upload" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:49%;">Upload</span>
                        <span class="btn btn-atualizar" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:49%;">Atualizar</span>
                    </div>

                    <div class="mb-1 destaque_content" id="content_list_individual_begin">

                        <div class="d-flex justify-content-around" style="flex-wrap:wrap;">

                            <div style="display:flex;flex-basis:100%;justify-content:center;border-bottom:2px solid white;margin-bottom:5px;padding:5px 0;">
                                <p style="margin:0;padding:0;">Listagem(Completa)</p>
                            </div>



                            <div style="display:flex;flex-basis:48%;">
                                <select id="mudar_ano_table" class="form-control">
                                    <option value="2023" selected>2023</option>
                                </select>
                            </div>

                            <div style="display:flex;flex-basis:48%;">
                                <select id="mudar_mes_table" class="form-control">
                                    <option value="" class="text-center">-Meses-</option>
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                            <div style="margin:20px 0;"></div>
                            <select style="flex-basis:98%;" id="select_usuario_individual" class="form-control">
                                <option value="todos" class="text-center" data-id="0">---Escolher Corretor---</option>
                                @foreach($corretores as $c)
                                    <option value="{{$c->name}}" data-id="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>


                        </div>

                        <ul style="list-style:none;margin:0;padding:4px 0;" id="list_individual_begin">
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="individual">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Contratos:</span>
                                <span class="badge badge-light total_por_orcamento" style="display:flex;flex-basis:50%;justify-content: flex-end;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="individual">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Vidas:</span>
                                <span class="badge badge-light total_por_vida" style="display:flex;flex-basis:50%;justify-content: flex-end;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;" class="individual">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Valor:</span>
                                <span class="badge badge-light total_por_page" style="display:flex;flex-basis:50%;justify-content: flex-end;">0</span>
                            </li>
                        </ul>
                    </div>
                    <div style="background-color:red;border-radius:5px;margin-bottom:3px;">
                        <ul style="list-style:none;margin:0;padding:6px 0;" id="atrasado_corretor">
                            <li style="padding:0px 1px;display:flex;justify-content:space-between;">
                                <span>Atrasados</span>
                                <span class="badge badge-light individual_quantidade_atrasado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="background-color:#123449;border-radius:5px;margin-bottom:3px;">
                        <ul style="list-style:none;margin:0;padding:6px 0;" id="finalizado_corretor">
                            <li style="padding:0px 1px;display:flex;justify-content:space-between;" id="aguardando_pagamento_6_parcela_individual" class="individual">
                                <span>Finalizado</span>
                                <span class="badge badge-light individual_quantidade_6_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="background-color:#123449;border-radius:5px;margin-bottom:3px;">
                        <ul style="list-style:none;margin:0;padding:6px 0;" id="cancelado_corretor">
                            <li style="padding:0px 1px;display:flex;justify-content:space-between;margin-bottom:4px;" id="cancelado_individual" class="individual">
                                <span>Cancelados</span>
                                <span class="badge badge-light individual_quantidade_cancelado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>




                    <div style="margin:0 0 5px 0;padding:0;background-color:#123449;border-radius:5px;">



                        <ul style="margin:0;padding:0;list-style:none;" id="listar_individual">
                            <li style="padding:0px 4px;display:flex;justify-content:space-between;margin-bottom:4px;" id="aguardando_pagamento_1_parcela_individual" class="individual">
                                <span>Pag. 1º Parcela</span>
                                <span class="badge badge-light individual_quantidade_1_parcela" style="width:45px;text-align:right;">0</span>
                            </li>


                            <li style="padding:0px 4px;display:flex;justify-content:space-between;margin-bottom:4px;" id="aguardando_pagamento_2_parcela_individual" class="individual">
                                <span>Pag. 2º Parcela</span>
                                <span class="badge badge-light individual_quantidade_2_parcela" style="width:45px;text-align:right;">0</span>
                            </li>

                            <li style="padding:0px 4px;display:flex;justify-content:space-between;margin-bottom:4px;" id="aguardando_pagamento_3_parcela_individual" class="individual">
                                <span>Pag. 3º Parcela</span>
                                <span class="badge badge-light individual_quantidade_3_parcela" style="width:45px;text-align:right;">0</span>
                            </li>

                            <li style="padding:0px 4px;display:flex;justify-content:space-between;margin-bottom:4px;" id="aguardando_pagamento_4_parcela_individual" class="individual">
                                <span>Pag. 4º Parcela</span>
                                <span class="badge badge-light individual_quantidade_4_parcela" style="width:45px;text-align:right;">0</span>
                            </li>

                            <li style="padding:0px 4px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_5_parcela_individual" class="individual">
                                <span>Pag. 5º Parcela</span>
                                <span class="badge badge-light individual_quantidade_5_parcela" style="width:45px;text-align:right;">0</span>
                            </li>


                        </ul>
                    </div>





                </div>
                <!--Fim Coluna da Esquerda  -->


                <!--COLUNA DA CENTRAL-->
                <div style="flex-basis:83%;">
                    <div style="background-color:#123449;color:#FFF;border-radius:5px;">
                        <table id="tabela_individual" class="table table-sm listarindividual w-100">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Cod.</th>
                                <th>Corretor</th>
                                <th>Cliente</th>
                                <th>CPF</th>
                                <th>Vidas</th>
                                <th>Valor</th>
                                <th>Venc.</th>
                                <th>Atrasado</th>
                                <th>Status</th>
                                <th>Ver</th>
                                <th>Atrasado</th>
                            </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
                <!--FIM COLUNA DA CENTRAL-->

                <!---------DIREITA-------------->

                <!---------FIM DIREITA-------------->
            </section>
        </main><!-------------------------------------DIV FIM Individial------------------------------------->
        <!-------------------------------------FIM Individial------------------------------------->

        <!------------------------------------------COLETIVO---------------------------------------------------->
        <main id="aba_coletivo" class="ocultar">
            <section class="d-flex justify-content-between" style="flex-wrap: wrap;align-content:flex-start;">
                <!--COLUNA DA ESQUERDA-->
                <div class="d-flex flex-column text-white" style="flex-basis:16%;border-radius:5px;">

                    <div class="d-flex mb-1 justify-content-between">
                        <span class="btn" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:49%;">
                            <a class="text-center text-white" href="{{route('contratos.create.coletivo')}}">Cadastrar</a>
                        </span>
                        <span class="btn btn_upload_coletivo" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:49%;">
                            Upload
                        </span>
                    </div>

                    <div id="content_list_coletivo_begin" class="destaque_content_radius">


                        <div style="display:flex;flex-basis:100%;justify-content:center;border-bottom:2px solid white;margin-bottom:5px;padding:5px 0;">
                            <p style="margin:0;padding:0;">Listagem(Completa)</p>
                        </div>

                        <div class="d-flex justify-content-around" style="flex-wrap:wrap;">
                            <div style="display:flex;flex-basis:48%;">
                                <select id="mudar_ano_table_coletivo" class="form-control">
                                    <option value="todos" class="text-center">-Anos-</option>
                                    @foreach($anos_coletivo as $ac)
                                        <option value="{{$ac->anos}}" {{date('Y') == $ac->anos ? 'selected' : ''}}>{{$ac->anos}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="display:flex;flex-basis:48%;margin-bottom:1%;">
                                <select id="mudar_mes_table_coletivo" class="form-control">
                                    <option value="00" class="text-center">-Meses-</option>
                                    @foreach($meses as $k =>$m)
                                        <option value="{{$k}}">{{$m}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <select class="form-control" style="flex-basis:98%;" id="select_usuario">
                                <option value="todos" class="text-center">---Escolher Corretor---</option>
                                @foreach($users as $u)
                                    <option value="{{$u->name}}" data-id="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                            <div style="margin-top:2px;height:2px;display:flex;flex-basis:98%;"></div> 

                            <select class="my-1 form-control" style="flex-basis:98%;margin-top:20px;" id="select_coletivo_administradoras">
                                <option value="todos" class="text-center">---Administradora---</option>
                                @foreach($administradoras as $ad)
                                    <option value="{{$ad->nome}}" data-id="{{$ad->id}}">{{$ad->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <ul style="list-style:none;margin:0;padding:4px 0;" id="list_coletivo_begin">
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="coletivo">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Contratos:</span>
                                <span class="badge badge-light total_por_orcamento_coletivo" style="display:flex;flex-basis:50%;justify-content:flex-end;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="coletivo">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Vidas:</span>
                                <span class="badge badge-light total_por_vida_coletivo" style="display:flex;flex-basis:50%;justify-content:flex-end;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;" class="coletivo">
                                <span style="display:flex;flex-basis:50%;font-weight:bold;">Valor:</span>
                                <span class="badge badge-light total_por_page_coletivo" style="display:flex;flex-basis:50%;justify-content:flex-end;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="background-color:red;border-radius:5px;margin:1px 0;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="atrasado_corretor_coletivo">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;">
                                <span>Atrasados</span>
                                <span class="badge badge-light coletivo_quantidade_atrasado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="border-radius:5px;margin:1px 0;background-color:#123449;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="finalizado_corretor_coletivo">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;">
                                <span>Finalizado</span>
                                <span class="badge badge-light quantidade_coletivo_finalizado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>


                    <div style="margin:0 0 3px 0;padding:0;background-color:#123449;border-radius:5px;">

                        <ul style="margin:0;padding:0;list-style:none;" id="listar">
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="em_analise_coletivo" class="fundo coletivo ">
                                <span>Em Analise</span>
                                <span class="badge badge-light coletivo_quantidade_em_analise" style="width:45px;text-align:right;vertical-align: middle;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="emissao_boleto_coletivo" class="coletivo">
                                <span>Emissão Boleto</span>
                                <span class="badge badge-light coletivo_quantidade_emissao_boleto" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_adesao_coletivo" class="coletivo">
                                <span>Pag. Adesão</span>
                                <span class="badge badge-light coletivo_quantidade_pagamento_adesao" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_vigencia_coletivo" class="coletivo">
                                <span>Pag. Vigência</span>
                                <span class="badge badge-light coletivo_quantidade_pagamento_vigencia" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_segunda_parcela" class="coletivo">
                                <span>Pag. 2º Parcela</span>
                                <span class="badge badge-light coletivo_quantidade_segunda_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_terceira_parcela" class="coletivo">
                                <span>Pag. 3º Parcela</span>
                                <span class="badge badge-light coletivo_quantidade_terceira_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_quarta_parcela" class="coletivo">
                                <span>Pag. 4º Parcela</span>
                                <span class="badge badge-light coletivo_quantidade_quarta_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_quinta_parcela" class="coletivo">
                                <span>Pag. 5º Parcela</span>
                                <span class="badge badge-light coletivo_quantidade_quinta_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:3px;" id="pagamento_sexta_parcela" class="coletivo">
                                <span>Pag. 6º Parcela</span>
                                <span class="badge badge-light coletivo_quantidade_sexta_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="background-color:#123449;border-radius:5px;">

                        <ul style="list-style:none;margin:0;padding:5px 0;" id="grupo_finalizados">

                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:4px;" id="cancelado_coletivo" class="coletivo">
                                <span>Cancelados</span>
                                <span class="badge badge-light quantidade_coletivo_cancelados" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>


                </div>
                <!--FIM COLUNA DA ESQUERDA-->


                <!--COLUNA DA CENTRAL-->
                <div style="flex-basis:83%;">
                    <div style="background-color:#123449;color:#FFF;border-radius:5px;">
                        <table id="tabela_coletivo" class="table table-sm listardados w-100">

                            <thead>
                            <tr>
                                <th>Datas</th>
                                <th>Cod.</th>
                                <th>Corretor</th>
                                <th>Cliente</th>
                                <th>Admin</th>
                                <th>CPF</th>
                                <th>Vidas</th>
                                <th>Valor</th>
                                <th>Venc.</th>
                                <th>Status</th>
                                <th>Ver</th>
                                <th>Teste</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--FIM COLUNA DA CENTRAL-->

                <!--COLUNA DA DIREITA-->


            </section>

        </main>

        <main id="aba_empresarial" class="ocultar">

            <section class="d-flex justify-content-between" style="flex-wrap: wrap;">

                <!--COLUNA DA ESQUERDA-->
                <div class="d-flex flex-column text-white ml-1" style="flex-basis:16%;border-radius:5px;">

                    <div style="background-color:#123449;border-radius:5px;margin:1px 0;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="cadastrar_empresarial">
                            <li style="padding:0px 3px;display:flex;text-align:center;justify-content:center;">
                                <a class="text-center" href="{{route('contratos.create.empresarial')}}" style="color:#FFF;font-size:1.2em;text-align:center;display:flex;flex-basis:100%;justify-content: center;;">Financeiro</a>
                            </li>
                        </ul>
                    </div>


                    <div class="mb-1 mt-1 py-2" style="background-color:#123449;border-radius:5px;margin-bottom:3px;">

                        <div class="d-flex justify-content-around" style="flex-wrap:wrap;">

                            <div style="display:flex;flex-basis:48%;">
                                <select id="mudar_ano_table_empresarial" class="form-control">
                                    <option value="" class="text-center">-Anos-</option>
                                    <option value="2022">2022</option>
                                    <option value="2023" selected>2023</option>
                                </select>
                            </div>

                            <div style="display:flex;flex-basis:48%;">
                                <select id="mudar_mes_table_empresarial" class="form-control">
                                    <option value="" class="text-center">-Meses-</option>
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>

                            <select style="flex-basis:98%;" name="mudar_user_empresarial" id="mudar_user_empresarial" class="form-control my-2 mx-auto">
                                <option value="todos" class="text-center" data-id="0">---Escolher Corretor---</option>
                                @foreach($users as $u)
                                    <option value="{{$u->name}}" data-id="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <ul style="list-style:none;margin:0;padding:4px 0;" id="list_empresarial_begin">
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="empresarial">
                                <span>Contratos:</span>
                                <span class="badge badge-light total_por_orcamento_empresarial" style="width:80px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="empresarial">
                                <span>Vidas:</span>
                                <span class="badge badge-light total_por_vida_empresarial" style="width:80px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;" class="empresarial">
                                <span>Valor:</span>
                                <span class="badge badge-light total_por_page_empresarial" style="width:80px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>


                    <div style="background-color:red;border-radius:5px;margin:1px 0;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="atrasado_corretor_empresarial">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;" id="" class="empresarial">
                                <span>Atrasados</span>
                                <span class="badge badge-light empresarial_quantidade_atrasado" style="width:45px;text-align:right;">{{$qtd_empresarial_atrasado}}</span>
                            </li>
                        </ul>
                    </div>

                    <div style="border-radius:5px;margin:1px 0;background-color:#123449;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="finalizado_corretor_empresarial">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;" id="" class="empresarial">
                                <span>Finalizado</span>
                                <span class="badge badge-light quantidade_empresarial_finalizado" style="width:45px;text-align:right;">{{$qtd_empresarial_finalizado}}</span>
                            </li>
                        </ul>
                    </div>


                    <div style="margin:0 0 5px 0;padding:5px 0 0 0;background-color:#123449;border-radius:5px;">

                        <ul style="margin:0;padding:0;list-style:none;" id="listar_empresarial">

                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_em_analise_empresarial"  class="empresarial">
                                <span>Em Análise</span>
                                <span class="badge badge-light empresarial_quantidade_em_analise" style="width:45px;text-align:right;">{{$qtd_empresarial_em_analise}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_1_parcela_empresarial" class="empresarial">
                                <span>Pag. 1º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_1_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_01}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_2_parcela_empresarial" class="empresarial">
                                <span>Pag. 2º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_2_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_02}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_3_parcela_empresarial" class="empresarial">
                                <span>Pag. 3º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_3_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_03}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_4_parcela_empresarial" class="empresarial">
                                <span>Pag. 4º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_4_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_04}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_5_parcela_empresarial" class="empresarial">
                                <span>Pag. 5º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_5_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_05}}</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_6_parcela_empresarial" class="empresarial">
                                <span>Pag. 6º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_6_parcela" style="width:45px;text-align:right;">{{$qtd_empresarial_parcela_06}}</span>
                            </li>
                        </ul>
                    </div>


                    <div style="background-color:#123449;border-radius:5px;">
                        <ul style="list-style:none;margin:0;padding:10px 0;" id="grupo_finalizados_empresarial">

                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_cancelado_empresarial" class="empresarial">
                                <span>Cancelado</span>
                                <span class="badge badge-light empresarial_quantidade_cancelado" style="width:45px;text-align:right;">{{$qtd_empresarial_cancelado}}</span>
                            </li>
                        </ul>
                    </div>







                </div>
                <!--Fim Coluna da Esquerda  -->

                <!--COLUNA DA CENTRAL-->
                <div style="flex-basis:83%;">
                    <div class="p-2" style="background-color:#123449;color:#FFF;border-radius:5px;">
                        <table id="tabela_empresarial" class="table table-sm listarempresarial" style="table-layout: fixed;">

                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Cod.</th>
                                <th>Corretor</th>
                                <th>Cliente</th>
                                <th>CNPJ</th>
                                <th>Vidas</th>
                                <th>Valor</th>
                                <th>Plano</th>
                                <th>Venc.</th>
                                <th>Status</th>
                                <th>Detalhes</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--FIM COLUNA DA CENTRAL-->

                <!---Coluna Direita--->

                <!---------FIM DIREITA----------->
        </main>


        <main id="aba_sem_carteirinha" class="ocultar">
            <div class="p-2" style="background-color:#123449;color:#FFF;border-radius:5px;">
                <table id="tablesemcarteirinha" class="table table-sm table_sem_carteirinha">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Orçamento</th>
                        <th>Corretor</th>
                        <th>Cliente</th>
                        <th>CPF</th>
                        <th>Vidas</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>

    </section>



@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>


    <script>
        $(document).ready(function(){

            $(".list_abas li").on('click',function(){
                $('li').removeClass('ativo');
                $(this).addClass("ativo");
                let id = $(this).attr('data-id');
                $("#janela_atual").val(id);
                $("#janela_ativa").val(id);
                default_formulario = $('.coluna-right.'+id).html();
                $('.conteudo_abas main').addClass('ocultar');
                $('#'+id).removeClass('ocultar');
                $('.next').attr('data-cliente','');
                $('.next').attr('data-contrato','');
                $('tr').removeClass('textoforte');
                if($(this).attr('data-id') == "aba_individual") {

                    

                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    table_individual.ajax.url("{{ route('financeiro.individual.geralIndividualPendentes') }}").load();

                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    table.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    tableempresarial.ajax.url('{{route("financeiro.zerar.financeiro")}}').load();

                    

                    $("#mudar_mes_table_coletivo").val("00");
                    $("#select_usuario").val('todos');
                    $("#select_coletivo_administradoras").val('todos');

                    $("#select_usuario").trigger('change');
                    


                } else if($(this).attr('data-id') == "aba_coletivo") {
                    
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    table_individual.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    tableempresarial.ajax.url('{{route("financeiro.zerar.financeiro")}}').load();
                    
                    inicializarColetivo();

                    // $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table.ajax.url("{{ route('financeiro.coletivo.em_geral') }}").load();

                } else {

                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    table.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    table_individual.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();
                    
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.listarContratoEmpresaPendentes")}}').load();

                }
                $("#cliente_id_alvo").val('');
                $("#cliente_id_alvo_individual").val('');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#listar li.coletivo").removeClass('textoforte-list');
                $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                $("ul#listar_individual li.individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
            });


            var table;
            function inicializarColetivo() {
                table = $(".listardados").DataTable({
                    dom: '<"d-flex justify-content-between"<"#title_coletivo_por_adesao_table">ftr><t><"d-flex justify-content-between"lp>',
                    language: {
                        "search": "Pesquisar",
                        "paginate": {
                            "next": "Próx.",
                            "previous": "Ant.",
                            "first": "Primeiro",
                            "last": "Último"
                        },
                        "emptyTable": "Nenhum registro encontrado",
                        "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "infoFiltered": "(Filtrados de _MAX_ registros)",
                        "infoThousands": ".",
                        "loadingRecords": "Carregando...",
                        "processing": "Processando...",
                        "lengthMenu": "Exibir _MENU_ por página"
                    },
                    processing: true,
                    ajax: {
                        "url":"{{ route('financeiro.coletivo.em_geral') }}",
                        "dataSrc": ""
                    },
                    "lengthMenu": [10,20,30],
                    "ordering": false,
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    columns: [
                        {data:"data",name:"data"},
                        {data:"orcamento",name:"codigo_externo"},
                        {data:"corretor",name:"corretor"},
                        {data:"cliente",name:"cliente"},
                        {data:"administradora",name:"administradora"},
                        {data:"cpf",name:"cpf"},
                        {data:"quantidade_vidas",name:"vidas"},
                        {data:"valor_plano",name:"valor_plano",render: $.fn.dataTable.render.number('.', ',', 2, 'R$ ')},
                        {data:"vencimento",name:"Vencimento"},
                        {data:"status",name:"status"},
                        {data:"id",name:"detalhes"},
                        {data:"resposta",name:"resposta"},
                    ],
                    "columnDefs": [
                        {
                            "targets": 10,
                            "width":"2%",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                var id = cellData;
                                $(td).html(`<div class='text-center text-white'>
                                        <a href="/admin/financeiro/detalhes/coletivo/${id}" class="text-white">
                                            <i class='fas fa-eye div_info'></i>
                                        </a>
                                    </div>
                                `);
                            },
                        },
                    ],
                    "initComplete": function( settings, json ) {
                        $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");
                        let api = this.api();
                        let dadosColuna9 = api.column(9,{search: 'applied'}).data();
                        let dadosColuna11 = api.column(11,{search: 'applied'}).data();
                        let contagemEmAnalise = 0;
                        let emissao = 0;
                        let adesao = 0;
                        let vigencia = 0;
                        let segundaParcela = 0;
                        let terceiraParcela = 0;
                        let quartaParcela = 0;
                        let quintaParcela = 0;
                        let sextaParcela = 0;
                        let finalizado = 0;
                        let cancelados = 0;
                        let atrasados = 0;
                        dadosColuna9.each(function (valor) {
                            if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                            if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                            if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                            if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                            if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                            if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                            if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                            if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                            if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                            if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                            if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                        });
                        dadosColuna11.each(function(valor){
                            if (valor.toLowerCase() == 'atrasado') {atrasados++;}
                        });
                        $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                        $(".coletivo_quantidade_emissao_boleto").text(emissao);
                        $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                        $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                        $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                        $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                        $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                        $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                        $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                        $(".quantidade_coletivo_finalizado").text(finalizado);
                        $(".quantidade_coletivo_cancelados").text(cancelados);                       
                        $(".coletivo_quantidade_atrasado").text(atrasados);                       
                    },
                    "footerCallback": function (row, data, start, end, display) {
                        let intVal = (i) =>  typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;               
                        total = this.api().column(7,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);},0);
                        total_vidas = this.api().column(6,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);},0);
                        total_linhas = this.api().column(5,{search: 'applied'}).data().count();
                        let total_br = total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                        $(".total_por_vida_coletivo").html(total_vidas);
                        $(".total_por_orcamento_coletivo").html(total_linhas);
                        $(".total_por_page_coletivo").html(total_br);
                    }
                });
            }
            
            
            $('#tabela_coletivo').on('click', 'tbody tr', function () {
                table.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
            });

            function inicializarIndividual() {

               $(".listarindividual").DataTable({
                    dom: '<"d-flex justify-content-between"<"#title_individual">ftr><t><"d-flex justify-content-between"lp>',
                    language: {
                        "search": "Pesquisar",
                        "paginate": {
                            "next": "Próx.",
                            "previous": "Ant.",
                            "first": "Primeiro",
                            "last": "Último"
                        },
                        "emptyTable": "Nenhum registro encontrado",
                        "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "infoFiltered": "(Filtrados de _MAX_ registros)",
                        "infoThousands": ".",
                        "loadingRecords": "Carregando...",
                        "processing": "Processando...",
                        "lengthMenu": "Exibir _MENU_ por página"
                    },
                    processing: true,
                    ajax: {
                        "url":"{{ route('financeiro.individual.geralIndividualPendentes') }}",
                        "dataSrc": ""
                    },
                    "lengthMenu": [500,1000],
                    "ordering": false,
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    columns: [
                        {data:"data",name:"data"},
                        {data:"orcamento",name:"orcamento"},
                        {data:"corretor",name:"corretor"},
                        {data:"cliente",name:"cliente"},
                        {data:"cpf",name:"cpf",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                let cpf = cellData.substr(0,3)+"."+cellData.substr(3,3)+"."+cellData.substr(6,3)+"-"+cellData.substr(9,2);
                                $(td).html(cpf);
                            }
                        },
                        {data:"quantidade_vidas",name:"vidas"},
                        {data:"valor_plano",name:"valor_plano",render: $.fn.dataTable.render.number('.', ',', 2, '')},
                        {data:"vencimento",name:"vencimento"},
                        {data:"vencimento",name:"atrasado"},
                        {data:"parcelas",name:"parcelas"},
                        {data:"id",name:"ver"},
                        {data:"status",name:"status"}
                    ],
                    "columnDefs": [
                        {"targets": 0,"width":"2%"},
                        {"targets": 1,"width":"5%"},
                        {"targets": 2,"width":"18%"},
                        {"targets": 3,"width":"18%"},
                        {"targets": 4,"width":"14%"},
                        {"targets": 5,"width":"5%"},
                        {"targets": 6,"width":"8%"},
                        {"targets": 7,"width":"5%"},
                        {"targets": 8,"width":"3%","visible": false},
                        {"targets": 9,"width":"10%"},
                        {"targets": 10,"width":"2%",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                if(cellData == "Cancelado") {
                                    var id = cellData;
                                    $(td).html(`<div class='text-center text-white'>
                                            <a href="/admin/financeiro/cancelado/detalhes/${id}" class="text-white">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        </div>
                                    `);
                                } else {
                                    var id = rowData.id;
                                    $(td).html(`<div class='text-center text-white'>
                                            <a href="/admin/financeiro/detalhes/${id}" class="text-white">
                                                <i class='fas fa-eye div_info'></i>
                                            </a>
                                        </div>
                                    `);
                                }
                            }
                        },
                        {"targets": 11,"visible":false}
                    ],
                    "initComplete": function( settings, json ) {
                        $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");
                        let countPagamento1 = this.api().column(9).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                        let countPagamento2 = this.api().column(9).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                        let countPagamento3 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                        let countPagamento4 = this.api().column(9).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                        let countPagamento5 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                        let countPagamento6 = this.api().column(9).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                        let countAtrasado = this.api().column(11).data().filter((value, index) => value === 'Atrasado').length;
                        let countCancelados = this.api().column(9).data().filter((value, index) =>  value === 'Cancelado').length;
                        $(".individual_quantidade_1_parcela").text(countPagamento1);
                        $(".individual_quantidade_2_parcela").text(countPagamento2);
                        $(".individual_quantidade_3_parcela").text(countPagamento3);
                        $(".individual_quantidade_4_parcela").text(countPagamento4);
                        $(".individual_quantidade_5_parcela").text(countPagamento5);
                        $(".individual_quantidade_6_parcela").text(countPagamento6);
                        $(".individual_quantidade_cancelado").text(countCancelados);
                        $(".individual_quantidade_atrasado").text(countAtrasado);    

                        const colunaNomes = this.api().column(2).data();
                        const nomesUnicos = new Set();
                        this.api()
                            .columns([0])
                            .every(function () {
                                var column = this;
                                var selectAno = $('#escolher_ano')
                                selectAno.on('change',function(){
                                    var vals = $.fn.dataTable.util.escapeRegex($(this).val());
                                    if(vals != "todos") {
                                        //console.log(vals);
                                        column.search(vals ? '^' + vals + '$' : '', true, false).draw();
                                    } else {
                                        var vals = "";
                                        column.search(vals ? '^' + vals + '$' : '', true, false).draw();
                                    }
                                });
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        //var data = d;
                                        var dd = new Date(d);
                                        var ano = dd.getFullYear();
                                        selectAno.append('<option value="' + ano + '">' + ano + '</option>');
                                    });
                            })
                        },
                        "drawCallback": function( settings ) {
                            var api = this.api();
                            if(settings.ajax.url.split('/')[6] == "atrsado") {
                                api.column(8).visible(true);
                            } else {
                                api.column(8).visible(false);
                            }
                        },

                        footerCallback: function (row, data, start, end, display) {
                            var intVal = (i) => typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                            total = this.api().column(6,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);}, 0);
                            total_vidas = this.api().column(5,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);},0);
                            total_linhas = this.api().column(5,{search: 'applied'}).data().count();
                            total_br = total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                            $(".total_por_page").html(total_br)
                            $(".total_por_vida").html(total_vidas);
                            $(".total_por_orcamento").html(total_linhas);
                        }          
                });
            }
            inicializarIndividual();

            var table_individual = $('#tabela_individual').DataTable();
            $('#tabela_individual').on('click', 'tbody tr', function () {
                table_individual.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
            });
            













            $("#select_coletivo_administradoras").on('change',function(){
                let admin = $("#select_coletivo_administradoras").val();
                let user_id = $("#select_usuario").find("option:selected").data("id");
                let mes = $("#mudar_mes_table_coletivo").val();                   
                mes = mes == "00" ? null : mes;
                
                user_id = user_id == undefined || user_id == 0 ? null : user_id;
                table.column(9).search('').draw();

                $("ul#listar li.coletivo").removeClass('textoforte-list');
                $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#listar li").removeClass('destaque_content');      
                $("#content_list_coletivo_begin").addClass('destaque_content_radius');  
                $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');                    
                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");


                if(admin != "todos") {
                    
                    if(mes) {
                        let mesAno = mes + '/' + new Date().getFullYear();
                        table.column(0).search(mesAno,true,false).draw(); 
                    }

                    if(user_id) {
                        let user_name = $("#select_usuario").find("option:selected").text();
                        table.column(2).search(user_name).draw();
                    }	



                    admin = admin == "todos" ? null : $("#select_coletivo_administradoras").find("option:selected").data("id");
                    let administradora = $(this).val();
                    table.column(4).search(administradora).draw();

                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let contagemEmAnalise = 0;
                    let emissao = 0;
                    let adesao = 0;
                    let vigencia = 0;
                    let segundaParcela = 0;
                    let terceiraParcela = 0;
                    let quartaParcela = 0;
                    let quintaParcela = 0;
                    let sextaParcela = 0;
                    let finalizado = 0;
                    let cancelados = 0;
                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                        if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                        if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                        if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                        if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                        if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                        
                    });

                    $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                    $(".coletivo_quantidade_emissao_boleto").text(emissao);
                    $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                    $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                    $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                    $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                    $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                    $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                    $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                    $(".quantidade_coletivo_finalizado").text(finalizado);
                    $(".quantidade_coletivo_cancelados").text(cancelados);

                   

                    
                    // $.ajax({
                    //     url:"{{route('financeiro.corretor.filtragem.coletivo.administradora')}}",
                    //     method:"POST",
                    //     data:"user_id="+user_id+"&mes="+mes+"&admin="+admin,
                    //     success:function(res) {
                            
                    //         $(".coletivo_quantidade_em_analise").html(res.quantidade_em_analise);
                    //         $(".coletivo_quantidade_emissao_boleto").html(res.quantidade_emissao_boleto);
                    //         $(".coletivo_quantidade_pagamento_adesao").html(res.quantidade_pagamento_adesao);
                    //         $(".coletivo_quantidade_pagamento_vigencia").html(res.quantidade_pagamento_vigencia);
                    //         $(".coletivo_quantidade_segunda_parcela").html(res.quantidade_segunda_parcela);
                    //         $(".coletivo_quantidade_terceira_parcela").html(res.quantidade_terceira_parcela);
                    //         $(".coletivo_quantidade_quarta_parcela").html(res.quantidade_quarta_parcela);
                    //         $(".coletivo_quantidade_quinta_parcela").html(res.quantidade_quinta_parcela);
                    //         $(".coletivo_quantidade_sexta_parcela").html(res.quantidade_sexta_parcela);
                    //         $(".coletivo_quantidade_atrasado").html(res.quantidade_atrasados);
                    //         $(".quantidade_coletivo_cancelados").html(res.quantidade_cancelados);
                    //     }
                    // });
                } else {
                    
                    table.column(4).search('').draw();

                    if(mes) {
                        let mesAno = mes + '/' + new Date().getFullYear();
                        table.column(0).search(mesAno, true, false).draw(); 
                    }

                    if(user_id) {
                        let user_name = $("#select_usuario").find("option:selected").text();
                        table.column(2).search(user_name).draw();
                    }

                    
                    
                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let contagemEmAnalise = 0;
                    let emissao = 0;
                    let adesao = 0;
                    let vigencia = 0;
                    let segundaParcela = 0;
                    let terceiraParcela = 0;
                    let quartaParcela = 0;
                    let quintaParcela = 0;
                    let sextaParcela = 0;
                    let finalizado = 0;
                    let cancelados = 0;
                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                        if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                        if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                        if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                        if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                        if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                        
                    });

                    $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                    $(".coletivo_quantidade_emissao_boleto").text(emissao);
                    $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                    $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                    $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                    $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                    $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                    $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                    $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                    $(".quantidade_coletivo_finalizado").text(finalizado);
                    $(".quantidade_coletivo_cancelados").text(cancelados);

                }
            });


            $("#select_usuario").select2({
                width:"98%",
                
            });

            $("#select_usuario_individual").select2({
                width:"98%",
                
            });




            $("#select_coletivo_administradoras").select2({
                width:"98%",
            });

            function aplicarEstilos() {
                $('.select2-results__option[role="option"]').css({
                    'font-size': '0.8em',
                    
                    // Adicione outras propriedades conforme necessário
                });
            }

            $('#select_usuario').on('select2:open', function() {
                setTimeout(aplicarEstilos,0);
            });

            $('#select_usuario_individual').on('select2:open', function() {
                setTimeout(aplicarEstilos,0);
            });

            $('#select_usuario').on('select2:select', aplicarEstilos);
            $('#select_usuario_individual').on('select2:select', aplicarEstilos);


            $("#select_usuario").on('change',function(){
                                  
                    let user_id = $(this).find("option:selected").data("id");
                    let mes = $("#mudar_mes_table_coletivo").val();
                    let admin = $("#select_coletivo_administradoras").val();

                    mes = mes == 00 ? null : mes;
                    admin = admin == "todos" ? null : $("#select_coletivo_administradoras").find("option:selected").data("id");
                    user_id = user_id == undefined ? null : user_id;

                    let corretorSelecionado = $(this).val();
                    table.search('').draw();
                    if (corretorSelecionado != 'todos') {
                        table.column(2).search(corretorSelecionado).draw();
                        
                        let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                        let contagemEmAnalise = 0;
                        let emissao = 0;
                        let adesao = 0;
                        let vigencia = 0;
                        let segundaParcela = 0;
                        let terceiraParcela = 0;
                        let quartaParcela = 0;
                        let quintaParcela = 0;
                        let sextaParcela = 0;
                        let finalizado = 0;
                        let cancelados = 0;
                        dadosColuna9.each(function (valor) {
                            if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                            if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                            if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                            if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                            if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                            if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                            if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                            if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                            if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                            if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                            if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                            
                        });

                        $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                        $(".coletivo_quantidade_emissao_boleto").text(emissao);
                        $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                        $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                        $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                        $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                        $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                        $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                        $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                        $(".quantidade_coletivo_finalizado").text(finalizado);
                        $(".quantidade_coletivo_cancelados").text(cancelados);
                    
                    
                    
                    
                    } else {

                        table.column(2).search('').draw();

                        let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                        let contagemEmAnalise = 0;
                        let emissao = 0;
                        let adesao = 0;
                        let vigencia = 0;
                        let segundaParcela = 0;
                        let terceiraParcela = 0;
                        let quartaParcela = 0;
                        let quintaParcela = 0;
                        let sextaParcela = 0;
                        let finalizado = 0;
                        let cancelados = 0;
                        dadosColuna9.each(function (valor) {
                            if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                            if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                            if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                            if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                            if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                            if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                            if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                            if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                            if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                            if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                            if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                            
                        });

                        $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                        $(".coletivo_quantidade_emissao_boleto").text(emissao);
                        $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                        $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                        $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                        $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                        $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                        $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                        $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                        $(".quantidade_coletivo_finalizado").text(finalizado);
                        $(".quantidade_coletivo_cancelados").text(cancelados);



                    }

                    return;

                    $.ajax({
                        url:"{{route('financeiro.corretor.filtragem.coletivo')}}",
                        method:"POST",
                        data:"user_id="+user_id+"&mes="+mes+"&admin="+admin,
                        success:function(res) {
                            console.log(res); 
                            $(".coletivo_quantidade_em_analise").html(res.quantidade_em_analise);
                            $(".coletivo_quantidade_emissao_boleto").html(res.quantidade_emissao_boleto);
                            $(".coletivo_quantidade_pagamento_adesao").html(res.quantidade_pagamento_adesao);
                            $(".coletivo_quantidade_pagamento_vigencia").html(res.quantidade_pagamento_vigencia);
                            $(".coletivo_quantidade_segunda_parcela").html(res.quantidade_segunda_parcela);
                            $(".coletivo_quantidade_terceira_parcela").html(res.quantidade_terceira_parcela);
                            $(".coletivo_quantidade_quarta_parcela").html(res.quantidade_quarta_parcela);
                            $(".coletivo_quantidade_quinta_parcela").html(res.quantidade_quinta_parcela);
                            $(".coletivo_quantidade_sexta_parcela").html(res.quantidade_sexta_parcela);
                            $(".coletivo_quantidade_atrasado").html(res.quantidade_atrasados);
                            $(".quantidade_coletivo_cancelados").html(res.quantidade_cancelados);
                            $(".quantidade_coletivo_finalizado").html(res.quantidade_finalizado);
                        }
                    });

                 
                

            });



            $("#listar_geral").on('click',function(){
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                table_individual.ajax.url("{{ route('financeiro.individual.geralIndividualPendentes') }}").load();
                $(".container_edit").addClass('ocultar')
                //adicionarReadonly();
                $("#atrasado_corretor").removeClass('textoforte-list');
                $("ul#listar_individual li.individual").removeClass('textoforte-list');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                $(this).addClass('textoforte-list');
                limparFormulario();
            });

            $("#mudar_ano_table").on('change',function(){
                var ano = $(this).val();
                var mes = $("#mudar_mes_table").val() != null ? $("#mudar_mes_table").val() : null;
                table_individual.ajax.url(`/admin/financeiro/individual/mudar_ano/${ano}/${mes}`).load();
            });
            var mes_old = "";
            $("#mudar_mes_table").on('change',function(){
                $("#select_usuario_individual").val('');
                $("#corretor_selecionado_id").val('');

                let mes = $(this).val() != "" ? $(this).val() : "00";

                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#content_list_individual_begin").addClass('destaque_content_radius');  
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");

                if(mes != 00) {


                    

                    table_individual.search('').columns().search('').draw();
                    let mesAno = mes + '/' + new Date().getFullYear();
                    table_individual.column(0).search(mesAno, true, false).draw();

                    let dadosColuna2 = table_individual.column(2,{search: 'applied'}).data().toArray();
                    
                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    
                    $("#select_usuario_individual").empty();

                    // Adicionar a opção padrão
                    $("#select_usuario_individual").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');

                    // Adicionar as opções ordenadas ao select
                    nomesUnicos.forEach((nome, index) => {
                        $("#select_usuario_individual").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });

                    // Inicializar o select2 novamente
                    $("#select_usuario_individual").select2();

                    let dadosColuna9 = table_individual.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table_individual.column(11,{search: 'applied'}).data();
                    let primeiraParcelaIndividual = 0;
                    let segundaParcelaIndividual = 0;
                    let terceiraParcelaIndividual = 0;
                    let quartaParcelaIndividual = 0;
                    let quintaParcelaIndividual = 0;
                    let sextaParcelaIndividual = 0;
                    let canceladosIndividual = 0;
                    let atrasadoIndividual = 0;
                    
                    
                    dadosColuna9.each(function (valor) {
                        
                        if (valor.toLowerCase() == 'pag. 1º parcela') {primeiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}
                                          
                    });

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                    });



                    $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                    $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                    $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                    $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                    $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                    $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                    $(".individual_quantidade_cancelado").text(canceladosIndividual);
                    $(".individual_quantidade_atrasado").text(atrasadoIndividual);
                
                } else {
                    table_individual.search('').columns().search('').draw();

                    let dadosColuna2 = table_individual.column(2,{search: 'applied'}).data().toArray();
                    
                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    
                    $("#select_usuario_individual").empty();

                    // Adicionar a opção padrão
                    $("#select_usuario_individual").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');

                    // Adicionar as opções ordenadas ao select
                    nomesUnicos.forEach((nome, index) => {
                        $("#select_usuario_individual").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });

                    // Inicializar o select2 novamente
                    $("#select_usuario_individual").select2();                  

                    let dadosColuna9 = table_individual.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table_individual.column(11,{search: 'applied'}).data();
                    let primeiraParcelaIndividual = 0;
                    let segundaParcelaIndividual = 0;
                    let terceiraParcelaIndividual = 0;
                    let quartaParcelaIndividual = 0;
                    let quintaParcelaIndividual = 0;
                    let sextaParcelaIndividual = 0;
                    let canceladosIndividual = 0;
                    let atrasadoIndividual = 0;
                    
                    
                    dadosColuna9.each(function (valor) {
                        
                        if (valor.toLowerCase() == 'pag. 1º parcela') {primeiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}
                                          
                    });

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                    });



                    $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                    $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                    $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                    $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                    $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                    $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                    $(".individual_quantidade_cancelado").text(canceladosIndividual);
                    $(".individual_quantidade_atrasado").text(atrasadoIndividual);




                }    






















                return;




                let ano = $("#mudar_ano_table").val() != null ? $("#mudar_ano_table").val() : null;
                table_individual.ajax.url(`/admin/financeiro/individual/mudar_mes/${mes}/${ano}`).load();
                let valorSelecionado = "";
                $('#tabela_individual').DataTable().column(2).search(valorSelecionado).draw();
                $.ajax({
                    url:"{{route('financeiro.montar.mes')}}",
                    method:"POST",
                    data:"mes="+mes,
                    success:function(res) {
                        
                        $(".individual_quantidade_1_parcela").html(res.qtd_individual_parcela_01);
                        $(".individual_quantidade_2_parcela").html(res.qtd_individual_parcela_02);
                        $(".individual_quantidade_3_parcela").html(res.qtd_individual_parcela_03);
                        $(".individual_quantidade_4_parcela").html(res.qtd_individual_parcela_04);
                        $(".individual_quantidade_5_parcela").html(res.qtd_individual_parcela_05);
                        $(".individual_quantidade_6_parcela").html(res.qtd_individual_parcela_06);
                        $(".individual_quantidade_atrasado").html(res.qtd_individual_atrsado);
                        $(".individual_quantidade_cancelado").html(res.qtd_individual_cancelado);
                        let select = $("#select_usuario_individual");
                        $("#select_usuario_individual").html('<option value="todos" class="text-center" data-id="0">--Escolher Corretor--</option>')
                        $.each(res.contratos, function(index, item) {
                            var option = $('<option>', { value: item.name, text: item.name,'data-id':item.id });
                            select.append(option);
                        });
                        
                        $("#content_list_individual_begin").addClass('destaque_content_radius');

                        $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                        $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                        $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');




                        $("#listar_individual li").removeClass('ativo');
                    }
                });
            });

            function totalMes() {
                return $("#select_usuario_individual").val();
            }

            $("#mudar_ano_table_coletivo").on('change',function(){
                var ano = $(this).val();
                var mes = $("#mudar_mes_table_coletivo").val() != null ? $("#mudar_mes_table_coletivo").val() : null;
                table.ajax.url(`/admin/financeiro/coletivo/mudar_ano/${ano}/${mes}`).load();
            });






            $("#mudar_mes_table_coletivo").on('change',function(){
                let mes = $(this).val();
                
                $("ul#listar li.coletivo").removeClass('textoforte-list');
                $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#listar li").removeClass('destaque_content');      
                $("#content_list_coletivo_begin").addClass('destaque_content_radius');  
                $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');                    
                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");






                if(mes != 00) {
                    
                    table.search('').columns().search('').draw();
                    let mesAno = mes + '/' + new Date().getFullYear();
                    table.column(0).search(mesAno, true, false).draw();

                    let dadosColuna2 = table.column(2,{search: 'applied'}).data().toArray();
                    
                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    
                    $("#select_usuario").empty();

                    // Adicionar a opção padrão
                    $("#select_usuario").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');

                    // Adicionar as opções ordenadas ao select
                    nomesUnicos.forEach((nome, index) => {
                        $("#select_usuario").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });

                    // Inicializar o select2 novamente
                    $("#select_usuario").select2();

                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let contagemEmAnalise = 0;
                    let emissao = 0;
                    let adesao = 0;
                    let vigencia = 0;
                    let segundaParcela = 0;
                    let terceiraParcela = 0;
                    let quartaParcela = 0;
                    let quintaParcela = 0;
                    let sextaParcela = 0;
                    let finalizado = 0;
                    let cancelados = 0;
                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                        if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                        if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                        if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                        if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                        if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                        
                    });

                    $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                    $(".coletivo_quantidade_emissao_boleto").text(emissao);
                    $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                    $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                    $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                    $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                    $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                    $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                    $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                    $(".quantidade_coletivo_finalizado").text(finalizado);
                    $(".quantidade_coletivo_cancelados").text(cancelados);
                } else {
                    table.search('').columns().search('').draw();
                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let contagemEmAnalise = 0;
                    let emissao = 0;
                    let adesao = 0;
                    let vigencia = 0;
                    let segundaParcela = 0;
                    let terceiraParcela = 0;
                    let quartaParcela = 0;
                    let quintaParcela = 0;
                    let sextaParcela = 0;
                    let finalizado = 0;
                    let cancelados = 0;
                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'em análise') {contagemEmAnalise++;}
                        if (valor.toLowerCase() == 'emissão boleto') {emissao++;}
                        if (valor.toLowerCase() == 'pag. vigência') {vigencia++;}
                        if (valor.toLowerCase() == 'pag. adesão') {adesao++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcela++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcela++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcela++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcela++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcela++;}
                        if (valor.toLowerCase() == 'finalizado') {finalizado++;}
                        if (valor.toLowerCase() == 'cancelado') {cancelados++;}
                        
                    });

                    $(".coletivo_quantidade_em_analise").text(contagemEmAnalise);
                    $(".coletivo_quantidade_emissao_boleto").text(emissao);
                    $(".coletivo_quantidade_pagamento_adesao").text(adesao);
                    $(".coletivo_quantidade_pagamento_vigencia").text(vigencia);
                    $(".coletivo_quantidade_segunda_parcela").text(segundaParcela);
                    $(".coletivo_quantidade_terceira_parcela").text(terceiraParcela);
                    $(".coletivo_quantidade_quarta_parcela").text(quartaParcela);
                    $(".coletivo_quantidade_quinta_parcela").text(quintaParcela);
                    $(".coletivo_quantidade_sexta_parcela").text(sextaParcela);
                    $(".quantidade_coletivo_finalizado").text(finalizado);
                    $(".quantidade_coletivo_cancelados").text(cancelados);
                    
                }

                
                return;
               
                
                //let ano = $("#mudar_ano_table_coletivo").val() != null ? $("#mudar_ano_table_coletivo").val() : null;


                
                //table.ajax.url(`/admin/financeiro/coletivo/mudar_mes/${mes}/${ano}`).load();


                
                

                $.ajax({
                    url:"{{route('financeiro.montar.mes.coletivo')}}",
                    method:"POST",
                    data:"mes="+mes,
                    success:function(res) {
                        //console.log(res);
                        $(".coletivo_quantidade_em_analise").text(res.qtd_coletivo_em_analise);
                        $(".coletivo_quantidade_emissao_boleto").text(res.qtd_coletivo_emissao_boleto);
                        $(".coletivo_quantidade_pagamento_adesao").text(res.qtd_coletivo_pg_adesao);
                        $(".coletivo_quantidade_pagamento_vigencia").text(res.qtd_coletivo_pg_vigencia);
                        $(".coletivo_quantidade_segunda_parcela").text(res.qtd_coletivo_02_parcela);
                        $(".coletivo_quantidade_terceira_parcela").text(res.qtd_coletivo_03_parcela);
                        $(".coletivo_quantidade_quarta_parcela").text(res.qtd_coletivo_04_parcela);
                        $(".coletivo_quantidade_quinta_parcela").text(res.qtd_coletivo_05_parcela);
                        $(".coletivo_quantidade_sexta_parcela").text(res.qtd_coletivo_06_parcela);
                        $(".quantidade_coletivo_finalizado").text(res.qtd_coletivo_finalizados);
                        $(".quantidade_coletivo_cancelados").text(res.qtd_coletivo_cancelados);
                        
                        let select = $("#select_usuario");
                        $("#select_usuario").html('<option value="todos" class="text-center" data-id="0">--Escolher Corretor--</option>')
                        $.each(res.contratos, function(index, item) {
                            var option = $('<option>', { value: item.name, text: item.name,'data-id':item.id });
                            select.append(option);
                        });

                        let administradoras = $("#select_coletivo_administradoras");
                        $("#select_coletivo_administradoras").html('<option value="todos" class="text-center" data-id="0">--Administradora--</option>')
                        $.each(res.administradoras, function(index, item) {
                            var option = $('<option>', { value: item.nome, text: item.nome,'data-id':item.id });
                            administradoras.append(option);
                        });



                    }
                });






            });

            $("#mudar_user_empresarial").on('change',function(){
                let mudar_user_empresarial = $(this).val();
                let user_id = $(this).find(':selected').data('id');
                let mudar_mes_table_empresarial = $("#mudar_mes_table_empresarial").val();

                $.ajax({
                   url:"{{route('contratos.empresarial.quantidade')}}",
                   method:"POST",
                   data:"user_id="+user_id+"&mes="+mudar_mes_table_empresarial,
                   success:function(res) {
                        
                       $(".empresarial_quantidade_em_analise").text(res.qtd_empresarial_em_analise);
                       $(".empresarial_quantidade_1_parcela").text(res.qtd_empresarial_parcela_01);
                       $(".empresarial_quantidade_2_parcela").text(res.qtd_empresarial_parcela_02);
                       $(".empresarial_quantidade_3_parcela").text(res.qtd_empresarial_parcela_03);
                       $(".empresarial_quantidade_4_parcela").text(res.qtd_empresarial_parcela_04);
                       $(".empresarial_quantidade_5_parcela").text(res.qtd_empresarial_parcela_05);
                       $(".empresarial_quantidade_6_parcela").text(res.qtd_empresarial_parcela_06);
                       $(".empresarial_quantidade_cancelado").text(res.qtd_empresarial_cancelado);
                       $(".empresarial_quantidade_atrasado").text(res.qtd_empresarial_atrasado);
                   }
                });

                if($(this).val() != "todos") {
                    tableempresarial.column(2).search($(this).val()).draw();
                } else {
                    var val = "";
                    tableempresarial.column(2).search(val).draw();
                    tableempresarial.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
                }
            });



            // $("#uploadModal").on('shown.bs.modal', function (event) {
            //     $("#uploadModal").css("z-index","1");
            //     //$("#error_data_baixa_individual").html('');
            // });

            $(".btn-upload").on('click',function(){
                $('#uploadModal').modal('show')
            });

            $(".btn_upload_coletivo").on('click',function(){

                $('#uploadModalColetivo').modal('show')
            });

            $(".btn-atualizar").on('click',function(){
                var load = $(".ajax_load");
                $.ajax({
                    url:"{{route('financeiro.sincronizar.baixas.jaexiste')}}",
                    method:"POST",
                    beforeSend: function () {
                        load.fadeIn(200).css("display", "flex");
                    },
                    success:function(res) {
                        window.location.reload();
                    }
                })
            });

            /*************************************************REALIZAR UPLOAD DO EXCEL*********************************************************************/
            $("#arquivo_upload").on('change',function(e){
                var files = $('#arquivo_upload')[0].files;
                var load = $(".ajax_load");
                // let file = $(this).val();
                var fd = new FormData();
                fd.append('file',files[0]);
                // fd.append('file',e.target.files[0]);
                $.ajax({
                    url:"{{route('financeiro.sincronizar')}}",
                    method:"POST",
                    data:fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        load.fadeIn(200).css("display", "flex");
                        $('#uploadModal').modal('hide');
                    },
                    success:function(res) {

                        if(res == "sucesso") {
                            load.fadeOut(200);
                            $('#uploadModal').modal('show');
                            $(".div_icone_arquivo_upload").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            $("#arquivo_upload").val('').prop('disabled',true);

                        } else {

                        }

                    }
                });
            });

            /*************************************************Atualizar Dados*********************************************************************/
            $(".atualizar_dados").on('click',function(){
                var load = $(".ajax_load");

                $.ajax({
                    url:"{{route('financeiro.atualizar.dados')}}",
                    method:"POST",


                    beforeSend: function (res) {
                        load.fadeIn(200).css("display", "flex");
                        $('#uploadModal').modal('hide')

                    },
                    success:function(res) {
                        if (res == "sucesso") {
                            load.fadeOut(200);
                            $('#uploadModal').modal('show');
                            $(".div_icone_arquivo_upload").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            $(".div_icone_atualizar_dados").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            $(".atualizar_dados").removeClass('btn-warning').addClass('btn-secondary').prop('disabled',true);
                            $("#arquivo_upload").val('').prop('disabled',true);
                            //window.location.href = response.redirect;
                        }
                    }
                });

                return false;
            });
            /*************************************************Sincronizar Dados*********************************************************************/
            $(".sincronizar_baixas").on('click',function(){
                var load = $(".ajax_load");
                $.ajax({
                    url:"{{route('financeiro.sincronizar.baixas')}}",
                    method:"POST",
                    beforeSend: function (res) {
                        load.fadeIn(200).css("display", "flex");
                        $('#uploadModal').modal('hide')

                    },
                    success:function(res) {

                        if(res == "sucesso") {
                            window.location.reload();
                        } else {

                        }
                    }
                });
                return false;
            });

            /*****************************************************UPLOAD COLETIVO****************************************************************************** */
            $("#arquivo_upload_coletivo").on('change',function(e){
                var files = $('#arquivo_upload_coletivo')[0].files;
                var load = $(".ajax_load");
                var fd = new FormData();
                fd.append('file',files[0]);
                $.ajax({
                    url:"{{route('financeiro.sincronizar.coletivo')}}",
                    method:"POST",
                    data:fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        load.fadeIn(200).css("display", "flex");
                        $('#uploadModalColetivo').modal('hide');
                    },
                    success:function(res) {
                        
                        if(res == "sucesso") {
                            load.fadeOut(200);

                            //$('#uploadModalColetivo').modal('show');
                            //$(".div_icone_arquivo_upload").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            //$("#arquivo_upload").val('').prop('disabled',true);

                        } else {

                        }

                    }
                });
            })
            /*****************************************************FIM UPLOAD COLETIVO****************************************************************************** */

            var default_formulario = $('.coluna-right.aba_individual').html();

            $('#cpf_financeiro_coletivo_view').mask('000.000.000-00');
            $('#telefone_coletivo_view').mask('(00) 0000-0000');
            $("#dataBaixaIndividualModal").on('hidden.bs.modal', function (event) {
                $("#error_data_baixa_individual").html('');
            });
            $("#dataBaixaIndividualModal").on('shown.bs.modal', function (event) {
                $("#error_data_baixa_individual").html('');
            });

            $("body").on('click','.excluir_individual',function(){
                if($(this).attr('data-cliente-excluir-individual')) {
                    Swal.fire({
                        title: 'Você tem certeza que deseja realizar essa operação?',
                        showDenyButton: true,
                        confirmButtonText: 'Sim',
                        denyButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let id_cliente = $(this).attr('data-cliente-excluir-individual');
                            $.ajax({
                                url:"{{route('financeiro.excluir.cliente.individual')}}",
                                method:"POST",
                                data:"id_cliente="+id_cliente,
                                success:function(res) {
                                    if(res != "error") {
                                        $(".individual_quantidade_em_analise").html(res.qtd_individual_em_analise);
                                        $(".individual_quantidade_1_parcela").html(res.qtd_individual_01_parcela);
                                        $(".individual_quantidade_2_parcela").html(res.qtd_individual_02_parcela);
                                        $(".individual_quantidade_3_parcela").html(res.qtd_individual_03_parcela);
                                        $(".individual_quantidade_4_parcela").html(res.qtd_individual_04_parcela);
                                        $(".individual_quantidade_5_parcela").html(res.qtd_individual_05_parcela);
                                        $(".individual_quantidade_6_parcela").html(res.qtd_individual_06_parcela);
                                        $(".individual_quantidade_finalizado").html(res.qtd_individual_finalizado);
                                        $(".individual_quantidade_cancelado").html(res.qtd_individual_cancelado);
                                        table_individual.ajax.reload();
                                        limparFormularioIndividual();
                                    } else {
                                        Swal.fire('Opss', 'Erro ao excluir o cliente', 'error')
                                    }
                                }
                            });
                        } else if (result.isDenied) {
                            //
                        }
                    })
                }
            });

            $("body").on('click','.cancelar_individual',function(){
                $('#cancelarModal').modal('show')
            });

            String.prototype.ucWords = function () {
                let str = this.toLowerCase()
                let re = /(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g
                return str.replace(re, s => s.toUpperCase())
            }

            

            $('.editar_btn_individual').on('click',function(){
                let params = $("#cliente").prop('readonly');
                if(!params) {
                    adicionarReadonlyIndividual();
                } else {
                    removeReadonlyIndividual();
                }
            });

            $("body").on('change','.editar_campo_individual',function(){
                let alvo = $(this).attr('id');
                let valor = $("#"+alvo).val();
                let id_cliente = $("#cliente_id_alvo_individual").val();
                $.ajax({
                    url:"{{route('financeiro.editar.individual.campoIndividualmente')}}",
                    method:"POST",
                    data:"alvo="+alvo+"&valor="+valor+"&id_cliente="+id_cliente,
                    success:function(res) {
                        table_individual.ajax.reload();
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("form[name='data_da_baixa_individual']").on('submit',function(){
                let id_cliente = $('.next_individual').attr('data-cliente');
                let id_contrato = $('.next_individual').attr('data-contrato');
                $.ajax({
                    url:"{{route('financeiro.baixa.data.individual')}}",
                    method:"POST",
                    data: {
                        "id_cliente": id_cliente,
                        "id_contrato": id_contrato,
                        "data_baixa": $("#date_baixa_individual").val(),
                        "comissao_id": $("#comissao_id_baixa_individual").val()
                    },
                    beforeSend:function() {
                        if($("#date_baixa_individual").val() == "") {
                            $("#error_data_baixa_individual").html('<p class="alert alert-danger">O campo data é campo obrigatório</p>');
                            return false;
                        } else {
                            $("#error_data_baixa_individual").html('');
                        }
                    },
                    success:function(res) {
                        $('#dataBaixaIndividualModal').modal('hide');
                        $(".individual_quantidade_em_analise").html(res.qtd_individual_em_analise);
                        $(".individual_quantidade_1_parcela").html(res.qtd_individual_01_parcela);
                        $(".individual_quantidade_2_parcela").html(res.qtd_individual_02_parcela);
                        $(".individual_quantidade_3_parcela").html(res.qtd_individual_03_parcela);
                        $(".individual_quantidade_4_parcela").html(res.qtd_individual_04_parcela);
                        $(".individual_quantidade_5_parcela").html(res.qtd_individual_05_parcela);
                        $(".individual_quantidade_6_parcela").html(res.qtd_individual_06_parcela);
                        $(".individual_quantidade_finalizado").html(res.qtd_individual_finalizado);
                        $(".individual_quantidade_pendentes").html(res.qtd_individual_pendentes);
                        table_individual.ajax.reload();
                        limparFormulario();
                        $('#dataBaixaIndividualModal').modal('hide');
                        $('#date_baixa_individual').val('');
                        $('#error_data_baixa_individual').html('');
                    }
                });
                return false;
            });



            var tasemcarteirinha = $(".table_sem_carteirinha").DataTable({

                dom: '<"d-flex justify-content-between"<"#title_sem_carteirinha">ft><t><"d-flex justify-content-between"lp>',
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    //"url":"{{ route('financeiro.sem.carteirinha') }}",
                    "url":"{{route('financeiro.zerar.financeiro')}}",
                    "dataSrc": ""
                },
                "lengthMenu": [50,100,150,200,300,500],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {
                        data:"created_at",name:"data",
                        "createdCell": function (td, cellData, rowData, row, col) {
                            let datas = cellData.split("T")[0]
                            let alvo = datas.split("-").reverse().join("/")
                            $(td).html(alvo)
                        },
                    },
                    {
                        data:"codigo_externo",name:"codigo_externo"
                    },
                    {
                        data:"clientes.user.name",name:"corretor",
                        "createdCell": function (td, cellData, rowData, row, col) {
                            let palavra = cellData.split(" ");
                            if(palavra.length >= 3) {
                                $(td).html(palavra[0]+" "+palavra[1]+"...")
                            }
                        }
                    },
                    {
                        data:"clientes.nome",name:"cliente",
                        "createdCell":function(td,cellData,rowData,row,col) {
                            let palavras = cellData.ucWords();
                            let dados = palavras.split(" ");
                            if(dados.length >= 4) {
                                $(td).html(dados[0]+" "+dados[1]+" "+dados[2]+"...");
                            }
                        }
                    },
                    {
                        data:"clientes.cpf",name:"cpf",
                        "createdCell": function (td, cellData, rowData, row, col) {
                            let cpf = cellData.substr(0,3)+"."+cellData.substr(3,3)+"."+cellData.substr(6,3)+"-"+cellData.substr(9,2);
                            $(td).html(cpf);
                        }
                    },
                    {data:"clientes.quantidade_vidas",name:"vidas"},
                    {
                        data:"clientes.id",name:"id",
                        "createdCell": function (td, cellData, rowData, row, col) {
                            var id = rowData.id;
                            $(td).html(`
                                <div class='text-center text-white'>
                                    <i class="fas fa-edit editar_carteirinha" data-id="${id}"></i>
                                </div>
                            `);

                        }
                    }

                ],
                "initComplete": function( settings, json ) {
                    $('#title_sem_carteirinha').html("<h4 style='font-size:1em;margin-top:10px;'>Sem Carteirinha</h4>");
                }

            });


            $("body").on('click','.editar_carteirinha',function(){
                let id = $(this).attr('data-id');
                $("#carteirinha_id_input").val(id);
                $('#carteirinhaModal').modal('show');
            });

           

            function parseDate(dateString) {
                let parts = dateString.split("/");
                return new Date(parts[2], parts[1] - 1, parts[0]);
            }


            $("#atrasado_corretor_coletivo").on('click',function(){
                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Atrasado</h4>");
                table.column(9).search('').draw();
                table.column(11).search('Atrasado').draw();
                //table.search('').columns().search('').draw();
                //table.ajax.url("{{ route('financeiro.coletivo.atrasado') }}").load();
                // table.rows().every(function() {
                //     let rowData = this.data();
                //     let vencimentoDate = parseDate(rowData.vencimento);
                //     let today = new Date();

                //     if (vencimentoDate < today) {
                //         // A data de vencimento é anterior ao dia de hoje, o registro está atrasado
                //         console.log(rowData);

                //         // Aqui você pode adicionar o registro à tabela filtrada ou tomar outras medidas necessárias
                //     }
                // });





                $(".container_edit").addClass('ocultar');
                $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("ul#listar li.coletivo").removeClass('textoforte-list').removeClass('destaque_content');
                $("#grupo_finalizados").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_coletivo_begin").removeClass('destaque_content_radius');


                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
            });

            

            $("#select_usuario_individual").on('change',function(){
                let mes = $("#mudar_mes_table").val() == '' ? '00' : $("#mudar_mes_table").val();
                let id = $('option:selected', this).attr('data-id');
                let nome = $('option:selected', this).text();               
                let corretor = $("#corretor_selecionado_id").val();
                let valorSelecionado = $(this).val();

                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#content_list_individual_begin").addClass('destaque_content_radius');  
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");


                if(valorSelecionado != "todos") {
                    table_individual.column(9).search('').draw();
                    table_individual.column(2).search(valorSelecionado).draw();    
                    let dadosColuna9 = table_individual.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table_individual.column(11,{search: 'applied'}).data();
                    let primeiraParcelaIndividual = 0;
                    let segundaParcelaIndividual = 0;
                    let terceiraParcelaIndividual = 0;
                    let quartaParcelaIndividual = 0;
                    let quintaParcelaIndividual = 0;
                    let sextaParcelaIndividual = 0;
                    let canceladosIndividual = 0;
                    let atrasadoIndividual = 0;    

                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'pag. 1º parcela') {primeiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}
                    });

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                    });

                    $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                    $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                    $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                    $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                    $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                    $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                    $(".individual_quantidade_cancelado").text(canceladosIndividual);
                    $(".individual_quantidade_atrasado").text(atrasadoIndividual);


                } else {



                    table_individual.column(2).search('').draw();
                    //$('#tabela_individual').DataTable().column(2).search(valorSelecionado).draw();    
                    let dadosColuna9 = table_individual.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table_individual.column(11,{search: 'applied'}).data();
                    let primeiraParcelaIndividual = 0;
                    let segundaParcelaIndividual = 0;
                    let terceiraParcelaIndividual = 0;
                    let quartaParcelaIndividual = 0;
                    let quintaParcelaIndividual = 0;
                    let sextaParcelaIndividual = 0;
                    let canceladosIndividual = 0;
                    let atrasadoIndividual = 0;                  
                    dadosColuna9.each(function (valor) {
                        if (valor.toLowerCase() == 'pag. 1º parcela') {primeiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcelaIndividual++;}
                        if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}
                    });

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                    });

                    $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                    $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                    $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                    $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                    $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                    $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                    $(".individual_quantidade_cancelado").text(canceladosIndividual);
                    $(".individual_quantidade_atrasado").text(atrasadoIndividual);



                }




                

                return;






                // if(corretor) { $("#list_individual_begin").trigger('click');} 
                
                // $("#corretor_selecionado_id").val(id);
                
                // $.ajax({
                //     url:"{{route('financeiro.corretor.quantidade')}}",
                //     method:"POST",
                //     data:"id="+id+"&mes="+mes,
                //     success:function(res) {
                //         $('#title_individual').html(`<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>`);
                //         $("ul#listar_individual li.individual").removeClass('textoforte-list');
                //         $("#atrasado_corretor").removeClass('textoforte-list');
                //         $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                //         $("#all_pendentes_individual").addClass('textoforte-list');
                //         $(".individual_quantidade_pendentes").html(res.qtd_clientes);
                //         $(".individual_quantidade_1_parcela").html(res.qtd_individual_parcela_01);
                //         $(".individual_quantidade_2_parcela").html(res.qtd_individual_parcela_02);
                //         $(".individual_quantidade_3_parcela").html(res.qtd_individual_parcela_03);
                //         $(".individual_quantidade_4_parcela").html(res.qtd_individual_parcela_04);
                //         $(".individual_quantidade_5_parcela").html(res.qtd_individual_parcela_05);
                //         $(".individual_quantidade_6_parcela").html(res.qtd_individual_parcela_06);
                //         $(".individual_quantidade_cancelado").html(res.qtd_individual_cancelado);
                //         // $(".total_por_vida").html(res.qtd_vidas);
                //         // $(".total_por_orcamento").html(res.qtd_clientes);
                //         $(".individual_quantidade_atrasado").html(res.qtd_individual_atrasado);
                //     }
                // });
            });




            $('body').on('change','#data_vigencia_coletivo_view',function(){
                let valor = $(this).val();
                let cliente = $("#cliente_id_alvo").val();
                $.ajax({
                    url:"{{route('financeiro.mudarVigenciaColetivo')}}",
                    method:"POST",
                    data:"data="+valor+"&cliente_id="+cliente,
                });
            });

            

            







            $("form[name='colocar_carteirinha']").on('submit',function(){
                var load = $(".ajax_load");
                $.ajax({
                    url:"{{route('cliente.atualizar.carteirinha')}}",
                    method:"POST",
                    data:$(this).serialize(),
                    beforeSend: function () {
                        load.fadeIn(100).css("display", "flex");
                        $('#carteirinhaModal').modal('hide');
                    },
                    success:function(res) {
                        if(res == "error") {
                            load.fadeOut(300);
                            $('#carteirinhaModal').modal('show');
                            $("#carteirinha_error").html('<p class="alert alert-danger text-center">Carteirinha inválida, tente outra =/</p>')
                        } else {
                            load.fadeOut(300);
                            $('#carteirinhaModal').modal('hide');
                            $(".individual_quantidade_pendentes").html(res.qtd_clientes);
                            $(".individual_quantidade_1_parcela").html(res.qtd_individual_parcela_01);
                            $(".individual_quantidade_2_parcela").html(res.qtd_individual_parcela_02);
                            $(".individual_quantidade_3_parcela").html(res.qtd_individual_parcela_03);
                            $(".individual_quantidade_4_parcela").html(res.qtd_individual_parcela_04);
                            $(".individual_quantidade_5_parcela").html(res.qtd_individual_parcela_05);
                            $(".individual_quantidade_6_parcela").html(res.qtd_individual_parcela_06);
                            $(".individual_quantidade_cancelado").html(res.qtd_individual_cancelado);
                            // $(".total_por_vida").html(res.qtd_vidas);
                            // $(".total_por_orcamento").html(res.qtd_clientes);
                            // $(".individual_quantidade_atrasado").html(res.qtd_individual_atrasado);
                            tasemcarteirinha.ajax.reload();
                        }
                    }
                });
                return false;
            });

            $(".listarempresarial").DataTable({
                 dom: '<"d-flex justify-content-between"<"#title_empresarial">ftr><t><"d-flex justify-content-between"lp>',
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('financeiro.coletivo.em_branco') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [10,20,30,300],
                "ordering": false,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                columns: [
                    {data:"created_at",name:"created_at",width:"5%"},
                    {data:"codigo_externo",name:"codigo_externo",width:"4%"},
                    {data:"usuario",name:"usuario",width:"10%"},
                    {data:"razao_social",name:"razao_social",width:"23%"},
                    {data:"cnpj",name:"cnpj",width:"10%"},
                    {data:"quantidade_vidas",name:"vidas",width:"3%"},
                    {data:"valor_plano",name:"valor_plano",width:"5%",render: $.fn.dataTable.render.number('.', ',', 2, 'R$ ')},
                    {data:"plano",name:"plano",width:"8%"},
                    {data:"vencimento",name:"vencimento",width:"7%"},
                    {data:"status",name:"status",width:"5%"},
                    {data:"id",name:"id",width:"5%"},
                ],
                "columnDefs": [
                    {
                        "targets": 10,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            var id = cellData;
                            $(td).html(`<div class='text-center text-white'>
                                        <a href="/admin/financeiro/detalhes/empresarial/${id}" class="text-white">
                                            <i class='fas fa-eye div_info'></i>
                                        </a>
                                    </div>
                                `);
                        },
                    },

                ],
                "initComplete": function( settings, json ) {
                    $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Em Analise</h4>");
                    this.api()
                        .columns([2])
                        .every(function () {
                            var column = this;
                            var selectUsuario = $("#select_usuario");
                            selectUsuario.on('change',function(){
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                if(val != "todos") {
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                } else {
                                    var val = "";
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                }
                            });
                        })
                    this.api()
                        .columns([4])
                        .every(function () {
                            var column = this;
                            var selectAdministradora = $("#select_coletivo_administradoras");
                            selectAdministradora.on('change',function(){
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                if(val != "todos") {
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                } else {
                                    var val = "";
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                }
                            });
                        })
                },
                "drawCallback":function(settings) {

                },
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(6,{search: 'applied'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    total_vidas = api
                        .column(5,{search: 'applied'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    total_linhas = api
                        .column(5,{search: 'applied'})
                        .data()
                        .count();

                    let total_br = total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                    $(".total_por_orcamento_empresarial").html(total_linhas);
                    $(".total_por_vida_empresarial").html(total_vidas);
                    $(".total_por_page_empresarial").html(total_br);

                }
            });

            var tableempresarial = $('#tabela_empresarial').DataTable();
            $('#tabela_empresarial').on('click', 'tbody tr', function () {
                tableempresarial.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
            });

            let url = window.location.href.indexOf("?");
            if(url != -1) {

                var b =  window.location.href.substring(url);
                var alvo = b.split("=")[1];
                if(alvo == "coletivo") {

                    $('.list_abas li').removeClass('ativo');
                    $('.list_abas li:nth-child(2)').addClass("ativo");
                    $('.conteudo_abas main').addClass('ocultar');
                    $('#aba_coletivo').removeClass('ocultar');
                    var c = window.location.href.replace(b,"");
                    window.history.pushState({path:c},'',c);
                    $("#janela_atual").val("aba_coletivo");
                }
                if(alvo == "empresarial") {

                    $('.list_abas li').removeClass('ativo');
                    $('.list_abas li:nth-child(3)').addClass("ativo");
                    $('.conteudo_abas main').addClass('ocultar');
                    $("#aguardando_em_analise_empresarial").addClass("text")
                    $("#aguardando_em_analise_empresarial").addClass('textoforte-list');
                    $('#aba_empresarial').removeClass('ocultar');
                    var c = window.location.href.replace(b,"");
                    window.history.pushState({path:c},'',c);




                }
            }


            $("#mudar_mes_table_empresarial").on('change',function(){
                let mes = $(this).val();
                let user_id = $("#mudar_user_empresarial").find(':selected').data('id');

                let valorSelecionado = "";
	            $('#tabela_empresarial').DataTable().column(2).search(valorSelecionado).draw();

                let urlComParametro = "{{ route('contratos.mudar.mes.empresarial', ['mes' => '']) }}" + mes;
                tableempresarial.ajax.url(urlComParametro).load();




                $.ajax({
                   url:"{{route('contratos.empresarial.quantidade.mes')}}",
                   method:"POST",
                   data:"user_id="+user_id+"&mes="+mes,
                   success:function(res) {
                       
                       $(".empresarial_quantidade_em_analise").text(res.qtd_empresarial_em_analise);
                       $(".empresarial_quantidade_1_parcela").text(res.qtd_empresarial_parcela_01);
                       $(".empresarial_quantidade_2_parcela").text(res.qtd_empresarial_parcela_02);
                       $(".empresarial_quantidade_3_parcela").text(res.qtd_empresarial_parcela_03);
                       $(".empresarial_quantidade_4_parcela").text(res.qtd_empresarial_parcela_04);
                       $(".empresarial_quantidade_5_parcela").text(res.qtd_empresarial_parcela_05);
                       $(".empresarial_quantidade_6_parcela").text(res.qtd_empresarial_parcela_06);
                       $(".empresarial_quantidade_cancelado").text(res.qtd_empresarial_cancelado);
                       $(".empresarial_quantidade_atrasado").text(res.qtd_empesarial_atrasado);


                       let select = $("#mudar_user_empresarial");
			           $("#mudar_user_empresarial").html('<option value="todos" class="text-center" data-id="0">--Escolher Corretor--</option>') 
                       
                        $.each(res.users,function(index,item) {
				            var option = $('<option>', { value: item.name, text: item.name,'data-id':item.id });
				            select.append(option);
			            }); 



                       mudar_user_empresarial 


                   }
                });





            });







            $("#list_individual_begin").on('click',function(){

                table_individual.column(9).search('').draw();
                let mes = $("#mudar_mes_table").val() == '' ? '00' : $("#mudar_mes_table").val();
                let valorSelecionado = $("#select_usuario_individual").val();

                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#content_list_individual_begin").addClass('destaque_content_radius');  
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");

                if(mes != 00) {
                    table_individual.search('').columns().search('').draw();
                    let mesAno = mes + '/' + new Date().getFullYear();
                    table_individual.column(0).search(mesAno, true, false).draw();
                } else {
                    table_individual.column(0).search('').draw();
                }

                if(valorSelecionado != "todos") {
                    table_individual.column(2).search(valorSelecionado).draw();    
                } else {
                    table_individual.column(2).search('').draw();
                }

                let dadosColuna9 = table_individual.column(9,{search: 'applied'}).data();
                let dadosColuna11 = table_individual.column(11,{search: 'applied'}).data();
                let primeiraParcelaIndividual = 0;
                let segundaParcelaIndividual = 0;
                let terceiraParcelaIndividual = 0;
                let quartaParcelaIndividual = 0;
                let quintaParcelaIndividual = 0;
                let sextaParcelaIndividual = 0;
                let canceladosIndividual = 0;
                let atrasadoIndividual = 0;


                dadosColuna9.each(function (valor) {
                        
                    if (valor.toLowerCase() == 'pag. 1º parcela') {primeiraParcelaIndividual++;}
                    if (valor.toLowerCase() == 'pag. 2º parcela') {segundaParcelaIndividual++;}
                    if (valor.toLowerCase() == 'pag. 3º parcela') {terceiraParcelaIndividual++;}
                    if (valor.toLowerCase() == 'pag. 4º parcela') {quartaParcelaIndividual++;}
                    if (valor.toLowerCase() == 'pag. 5º parcela') {quintaParcelaIndividual++;}
                    if (valor.toLowerCase() == 'pag. 6º parcela') {sextaParcelaIndividual++;}
                    if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}
                                        
                });

                dadosColuna11.each(function (valor) {
                    if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                });


                $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                $(".individual_quantidade_cancelado").text(canceladosIndividual);
                $(".individual_quantidade_atrasado").text(atrasadoIndividual);

                return;        
                
                
                
                // let mes = $("#mudar_mes_table").val() == '' ? '00' : $("#mudar_mes_table").val();
                
                // $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;'>Listagem(Completa)</h4>");
                // table_individual.ajax.url(`{{ url('/admin/financeiro/individual/em_geral/${mes}') }}`).load();
                // $("#aguardando_pagamento_1_parcela_individual").removeClass('textoforte-list').removeClass('destaque_content');
                // $("#aguardando_pagamento_2_parcela_individual").removeClass('textoforte-list').removeClass('destaque_content');
                // $("#aguardando_pagamento_3_parcela_individual").removeClass('textoforte-list').removeClass('destaque_content');
                // $("#aguardando_pagamento_4_parcela_individual").removeClass('textoforte-list').removeClass('destaque_content');
                // $("#aguardando_pagamento_5_parcela_individual").removeClass('textoforte-list').removeClass('destaque_content');
                // $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                // $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                // $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');  



                // $("#listar_individual li").removeClass('destaque_content');
                // $("#content_list_individual_begin").addClass('destaque_content');



            });

            $("#list_coletivo_begin").on('click',function(){

                table.column(9).search('').draw();
                table.column(11).search('').draw();

                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");
                $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#emissao_boleto_coletivo").removeClass('textoforte-list').removeClass('destaque_content');
                $('#content_list_coletivo_begin').addClass('destaque_content_radius');

                // table.ajax.url("{{ route('financeiro.coletivo.em_geral') }}").load();
                // $("ul#listar li.coletivo").removeClass('textoforte-list');
                // $("#grupo_finalizados").removeClass('textoforte-list').removeClass('destaque_content_radius');
                // $("#listar li").removeClass('destaque_content');
                // $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                // $(this).closest('#content_list_coletivo_begin').addClass('destaque_content_radius');
                


            });

            $("#list_empresarial_begin").on('click',function(){
                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                $("#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.listarContratoEmpresaPendentes")}}').load();
            });

            $("body").on('click','.next_individual',function(){
                if($(this).attr('data-cliente') && $(this).attr('data-contrato')) {

                    let id_cliente = $(this).attr('data-cliente');
                    let id_contrato = $(this).attr('data-contrato');

                    $.ajax({
                        url:"{{route('financeiro.mudarStatusIndividual')}}",
                        data:"id_cliente="+id_cliente+"&id_contrato="+id_contrato,
                        method:"POST",
                        success:function(res) {

                            if(res == "abrir_modal_individual") {
                                //$('#dataBaixaModal').modal('show');
                                $("#dataBaixaIndividualModal").modal('show');
                            } else {

                                $(".individual_quantidade_em_analise").html(res.qtd_individual_em_analise);
                                $(".individual_quantidade_1_parcela").html(res.qtd_individual_01_parcela);
                                $(".individual_quantidade_2_parcela").html(res.qtd_individual_02_parcela);
                                $(".individual_quantidade_3_parcela").html(res.qtd_individual_03_parcela);
                                $(".individual_quantidade_4_parcela").html(res.qtd_individual_04_parcela);
                                $(".individual_quantidade_5_parcela").html(res.qtd_individual_05_parcela);
                                $(".individual_quantidade_6_parcela").html(res.qtd_individual_06_parcela);
                                $(".individual_quantidade_finalizado").html(res.qtd_individual_finalizado);

                                taindividual.ajax.reload();

                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        type: "error",
                        width: '400px',
                        html: "Tem que selecionar um item da tabela, para mudar de status"
                    })
                }
            });


            $("ul#listar li.coletivo").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "em_analise_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Em Análise</h4>");
                    //table.ajax.url("{{ route('financeiro.coletivo.em_analise') }}").load();
                    //let mes = $("#mudar_mes_table_coletivo").val();
                    //mes == '' ? '00' : mes;
                    
                    //table.ajax.url(`{{ url('admin/financeiro/coletivo/em_analise/${mes}') }}`).load();
                    //let userId = $("#select_usuario").find('option:selected').data('id');
                    //let administradora_id = $("#select_coletivo_administradoras").find('option:selected').data('id');
                    // Configuração da tabela DataTables
                    // $.ajax({
                    //     url: '{{ route("financeiro.coletivo.em_analise") }}',
                    //     type: 'POST',
                        //     data: {
                        //         userId,
                        //         mes,
                        //         administradora_id
                        //     },
                        //     success:function(res) {
                        //         console.log(res);
                        //     }
                        // });


                    table.column(11).search('').draw();        
                    table.column(9).search('Em Análise').draw();   
                    
                
                          
                    

                    $(".container_edit").removeClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#all_pendentes_coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius'); 
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "emissao_boleto_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Emissão Boleto</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Emissão Boleto').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.emissao_boleto') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');      
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');                    
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_adesao_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento Adesão</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. Adesão').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_adesao') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius'); 
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_vigencia_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento Vigência</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. Vigência').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_vigencia') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius'); 
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_segunda_parcela") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 2º Parcela</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. 2º Parcela').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_segunda_parcela') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius'); 
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_terceira_parcela") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 3º Parcela</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. 3º Parcela').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_terceira_parcela') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');                   
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius'); 
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_quarta_parcela") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 4º Parcela</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. 4º Parcela').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_quarta_parcela') }}").load();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');   
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "pagamento_quinta_parcela") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 5º Parcela</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. 5º Parcela').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_quinta_parcela') }}").load();
                    // $('.buttons').empty().html(
                    //     '<button class="btn btn-danger w-50 mr-2 cancelar">Cancelar</button>'+
                    //     '<button class="btn btn-success w-50 pagamento_quinta_parcela next">5º Parcela Paga</button>'
                    // );
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');                   
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');    
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');

                } else if(id_lista == "pagamento_sexta_parcela") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 6º Parcela</h4>");
                    table.column(11).search('').draw();
                    table.column(9).search('Pag. 6º Parcela').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.pagamento_sexta_parcela') }}").load();
                    // $('.buttons').empty().html(
                    //     '<button class="btn btn-danger w-50 mr-2 cancelar">Cancelar</button>'+
                    //     '<button class="btn btn-success w-50 pagamento_sexta_parcela next">6º Parcela Paga</button>'
                    // );
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content');        
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');  
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else {

                }
            });


            $("#finalizado_corretor_coletivo").on('click',function(){
                table.search('').columns().search('').draw();
                table.column(9).search('Finalizado').draw();
                //table.ajax.url("{{ route('financeiro.coletivo.finalizado')  }}").load();
                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                $("#grupo_finalizados").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("ul#listar li.coletivo").removeClass('textoforte-list').removeClass('destaque_content');
                $("#content_list_coletivo_begin").removeClass('destaque_content_radius');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
            });





            $("#all_pendentes_individual").on('click',function(){
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                table_individual.ajax.url("{{ route('financeiro.individual.geralIndividualPendentes') }}").load();
                $("ul#listar_individual li.individual").removeClass('textoforte-list');
                $("#atrasado_corretor").removeClass('textoforte-list');
                $(this).addClass('textoforte-list');
            });






            $("ul#listar_individual li.individual").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "aguardando_em_analise_individual") {
                    //table_individual.clear().draw();
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Em Análise</h4>");
                    
                    //table_individual.ajax.url("{{ route('financeiro.individual.em_analise') }}").load();
                    table_individual.column(9).search('Em Análise').draw();


                    $("#atrasado_corretor").removeClass('textoforte-list');
                    $(".container_edit").removeClass('ocultar')
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                } else if(id_lista == "aguardando_pagamento_1_parcela_individual") {
                    let mes = $("#mudar_mes_table").val();
                    let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                    //table_individual.clear().draw();
                    
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 1º Parcela</h4>");
                    table_individual.column(11).search('').draw();
                    //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_primeira_parcela/${dataId}/${mes}') }}`).load();
                    table_individual.column(9).search('Pag. 1º Parcela').draw();    


                    $(".container_edit").addClass('ocultar')
                    $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                    $("#listar_individual li").removeClass('destaque_content');
                    $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $("#finalizado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "aguardando_pagamento_2_parcela_individual") {
                    let mes = $("#mudar_mes_table").val();
                    let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                    //table_individual.clear().draw();
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 2º Parcela</h4>");
                    
                    table_individual.column(11).search('').draw();
                    table_individual.column(9).search('Pag. 2º Parcela').draw();
                    //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_segunda_parcela/${dataId}/${mes}') }}`).load();
                    
                    $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#cancelado_individual").removeClass('textoforte-list');
                    $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                    $("#listar_individual li").removeClass('destaque_content');
                    $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "aguardando_pagamento_3_parcela_individual") {
                    //table_individual.clear().draw();
                    let mes = $("#mudar_mes_table").val();
                    let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 3º Parcela</h4>");
                    
                    table_individual.column(11).search('').draw();
                    table_individual.column(9).search('Pag. 3º Parcela').draw();
                    //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_terceira_parcela/${dataId}/${mes}') }}`).load();
                    
                    $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(".container_edit").addClass('ocultar');
                    $("#cancelado_individual").removeClass('textoforte-list');
                    //adicionarReadonly();
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                    $("#listar_individual li").removeClass('destaque_content');
                    $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else if(id_lista == "aguardando_pagamento_4_parcela_individual") {
                    //table_individual.clear().draw();
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 4º Parcela</h4>");
                    let mes = $("#mudar_mes_table").val();
                    let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                    table_individual.column(11).search('').draw();
                    //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_quarta_parcela/${dataId}/${mes}') }}`).load();
                    table_individual.column(9).search('Pag. 4º Parcela').draw();
                    $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(".container_edit").addClass('ocultar')
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                    $("#listar_individual li").removeClass('destaque_content');
                    $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    $("#cancelado_individual").removeClass('textoforte-list');
                } else if(id_lista == "aguardando_pagamento_5_parcela_individual") {
                    //table_individual.clear().draw();
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 5º Parcela</h4>");
                    let mes = $("#mudar_mes_table").val();
                    let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                    table_individual.column(11).search('').draw();
                    //table_individual.ajax.url(`{{url('/admin/financeiro/individual/pagamento_quinta_parcela/${dataId}/${mes}')}}`).load();
                    table_individual.column(9).search('Pag. 5º Parcela').draw();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#cancelado_individual").removeClass('textoforte-list').removeClass('destaque_content_radius')
                    $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                    $("#listar_individual li").removeClass('destaque_content');
                    $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                } else {

                }
            });

            $("#aguardando_pagamento_6_parcela_individual").on('click',function(){
                //table_individual.clear().draw();
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Pagamento 6º Parcela</h4>");
                let mes = $("#mudar_mes_table").val();
                let dataId = $("#select_usuario_individual").find('option:selected').data('id');

                //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_sexta_parcela/${dataId}/${mes}') }}`).load();
                table_individual.column(11).search('').draw();                
                
                table_individual.column(9).search('Pag. 6º Parcela').draw();

                $(".container_edit").addClass('ocultar')
                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list')
                $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").addClass('textoforte-list').addClass('destaque_content_radius');
                $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
            });



            $("ul#grupo_finalizados li.coletivo").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "finalizado_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                    //table.ajax.url("{{ route('financeiro.coletivo.finalizado') }}").load();
                    $('.buttons').empty().html();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#all_pendentes_coletivo").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                } else if(id_lista == "cancelado_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                    table.column(9).search('Cancelado').draw();
                    //table.ajax.url("{{ route('financeiro.coletivo.cancelado') }}").load();
                    $('.buttons').empty().html();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#all_pendentes_coletivo").removeClass('textoforte-list');
                    $("#listar li").removeClass('destaque_content')
                    $("#content_list_coletivo_begin").removeClass('destaque_content_radius');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $(this).closest("ul").addClass('textoforte-list').addClass('destaque_content_radius');

                } else {

                }
            });

            


            $("#atrasado_corretor_empresarial").on('click',function(){
                $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Atrasado</h4>");
                tableempresarial.ajax.url("{{ route('contratos.listarEmpresarial.atrasados') }}").load();
            });

            $("#finalizado_corretor_empresarial").on('click',function(){
                $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                tableempresarial.ajax.url("{{ route('contratos.listarEmpresarial.finalizado') }}").load();
            });

            $("#atrasado_corretor").on('click',function(){
                let mes = $("#mudar_mes_table").val();
                let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                //table_individual.clear().draw();
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;'>Atrasado</h4>");
                //table_individual.search('').columns().search('').draw();
                table_individual.column(9).search('').draw();
                table_individual.column(11).search('Atrasado').draw();
                //table_individual.column(11).search('Pag. 1º Parcela').draw();
                //table_individual.ajax.url(`{{ url('/admin/financeiro/geral/atrsado/${dataId}/${mes}') }}`).load();
                
                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
                $("#aguardando_pagamento_6_parcela_individual").removeClass('textoforte-list');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_individual_begin").removeClass('destaque_content').removeClass('destaque_content_radius');
            });

            $("ul#grupo_finalizados_individual li.individual").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "finalizado_individual") {
                    $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                    table_individual.ajax.url("{{ route('financeiro.individual.finalizado') }}").load();
                    $('.button_individual').empty().html('');
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar_individual li.individual").removeClass('textoforte-list');
                    $("#all_pendentes_individual").removeClass('textoforte-list');
                    $("#atrasado_corretor").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                } else {

                }
            });

            $("#cancelado_individual").on('click',function(){
                let mes = $("#mudar_mes_table").val();
                let dataId = $("#select_usuario_individual").find('option:selected').data('id');
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                $('.button_individual').empty().html('');
                $(".container_edit").addClass('ocultar');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("ul#listar_individual li.individual").removeClass('textoforte-list');
                $("#aguardando_pagamento_6_parcela_individual").removeClass('textoforte-list');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                $("#finalizado_corretor").removeClass('textoforte-list');
                $("#listar_individual li").removeClass('destaque_content');
                $("#cancelado_corretor").addClass('textoforte-list');
                $("#cancelado_corretor").addClass('destaque_content_radius');
                $("#content_list_individual_begin").removeClass('destaque_content_radius').removeClass('destaque_content');
                $("#finalizado_corretor").removeClass('destaque_content_radius');


                
                table_individual.column(9).search('Cancelado').draw();

                //table_individual.ajax.url(`{{ url('/admin/financeiro/individual/pagamento_individual_cancelado/${dataId}/${mes}') }}`).load();


            });

            $("ul#grupo_finalizados_empresarial li.empresarial").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "aguardando_finalizado_empresarial") {
                    $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                    table_individual.ajax.url("{{ route('financeiro.individual.finalizado') }}").load();
                    $('.button_individual').empty().html('');
                    $(".container_edit").addClass('ocultar');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                } else if(id_lista == "aguardando_cancelado_empresarial") {
                    $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                    table_individual.ajax.url("{{ route('financeiro.individual.cancelado') }}").load();
                    $('.button_individual').empty().html('');
                    $(".container_edit").addClass('ocultar');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                } else {


                }
            });

            $("ul#listar_empresarial li.empresarial").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "aguardando_em_analise_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Em Análise</h4>");
                    $('.button_empresarial').empty().html(
                        '<button class="btn btn-danger w-50 mr-2 excluir_empresarial">Excluir</button>'+
                        '<button class="btn btn-success w-50 next_empresarial">Conferido</button>'
                    );
                    //$("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.analise")}}').load();
                } else if(id_lista == "aguardando_pagamento_1_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 1º Parcela</h4>");
                    // $('.button_empresarial').empty().html(
                    //     '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                    //     '<button class="btn btn-success w-50 emissao_boleto next_empresarial">1º Parcela Paga</button>'
                    // );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.primeiraparcela")}}').load();
                } else if(id_lista == "aguardando_pagamento_2_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 2º Parcela</h4>");
                    // $('.button_empresarial').empty().html(
                    //     '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                    //     '<button class="btn btn-success w-50 emissao_boleto next_empresarial">2º Parcela Paga</button>'
                    // );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.segundaparcela")}}').load();
                } else if(id_lista == "aguardando_pagamento_3_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 3º Parcela</h4>");
                    $('.button_empresarial').empty().html(
                        '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                        '<button class="btn btn-success w-50 emissao_boleto next_empresarial">3º Parcela Paga</button>'
                    );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.terceiraparcela")}}').load();
                } else if(id_lista == "aguardando_pagamento_4_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 4º Parcela</h4>");
                    $('.button_empresarial').empty().html(
                        '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                        '<button class="btn btn-success w-50 emissao_boleto next_empresarial">4º Parcela Paga</button>'
                    );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.quartaparcela")}}').load();
                } else if(id_lista == "aguardando_pagamento_5_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 5º Parcela</h4>");
                    $('.button_empresarial').empty().html(
                        '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                        '<button class="btn btn-success w-50 emissao_boleto next_empresarial">5º Parcela Paga</button>'
                    );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.quintaparcela")}}').load();
                } else if(id_lista == "aguardando_pagamento_6_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 6º Parcela</h4>");
                    $('.button_empresarial').empty().html(
                        '<button class="btn btn-danger w-50 mr-2 cancelar_empresarial">Cancelar</button>'+
                        '<button class="btn btn-success w-50 emissao_boleto next_empresarial">6º Parcela Paga</button>'
                    );
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.sextaparcela")}}').load();
                } else if(id_lista == "aguardando_finalizado_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                    $('.button_empresarial').empty().html('');
                    $("#all_pendentes_empresarial").removeClass('textoforte-list');
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.finalizado")}}').load();
                } else if(id_lista == "aguardando_cancelado_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                    tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.cancelado")}}').load();
                } else {

                }
            });
            var contar = 0;
            $(".div_info").on('click',function(){
                let contrato = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('contratos.info')}}",
                    data:"contrato="+contrato,
                    method:"POST",
                    success:function(res) {$('.container_div_info').html(res);}
                });
                $('.container_div_info').toggle();
                return false;
            });

            if($("#janela_atual").val() == "aba_coletivo") {

                table.on( 'xhr', function (e, settings, json) {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Contratos</h4>");
                    table.ajax.url("{{ route('financeiro.coletivo.em_geral') }}").load();
                    table.off( 'xhr' );
                });
            }


        });
    </script>
@stop


@section('css')
    <style>
        .fontsize0 option {font-size: 0.7em !important;}
        #content_list_coletivo_begin {background-color:#123449;border-radius:5px;padding}
        .destaque_content {border:4px solid #FFA500;}
        .destaque_content_radius {border:4px solid #FFA500;border-radius:5px;}
        #content_list_individual_begin {background-color:#123449;border-radius:5px;margin-bottom:3px;}
        .ajax_load {display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;}
        .ajax_load_box{margin:auto;text-align:center;color:#fff;font-weight:var(700);text-shadow:1px 1px 1px rgba(0,0,0,.5)}
        .ajax_load_box_circle{border:16px solid #e3e3e3;border-top:16px solid #61DDBC;border-radius:50%;margin:auto;width:80px;height:80px;-webkit-animation:spin 1.2s linear infinite;-o-animation:spin 1.2s linear infinite;animation:spin 1.2s linear infinite}
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
        #container_mostrar_comissao {width:439px;height:555px;background-color:#123449;position:absolute;right:5px;border-radius: 5px;}
        .container_edit {display:flex;justify-content:end;}
        .ativo {background-color:#FFF !important;color: #000 !important;}
        .ocultar {display: none;}
        .list_abas {list-style: none;display: flex;border-bottom: 1px solid white;margin: 4px 0;padding: 0;}
        .list_abas li {color: #fff;width: 150px;padding: 8px 5px;text-align:center;border-radius: 5px 5px 0 0;background-color:#123449;}
        .list_abas li:hover {cursor: pointer;}
        .list_abas li:nth-of-type(2) {margin: 0 1%;}
        .list_abas li:nth-of-type(4) {margin-left:1%;}
        .textoforte {background-color:rgba(255,255,255,0.5) !important;color:black;}
        .textoforte-list {background-color:rgba(255,255,255,0.5);color:white;}
        .botao:hover {background-color: rgba(0,0,0,0.5) !important;color:#FFF !important;}
        .valores-acomodacao {background-color:#123449;color:#FFF;width:32%;box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;}
        .valores-acomodacao:hover {cursor:pointer;box-shadow: none;}
        .table thead tr {background-color:#123449;color: white;}
        .destaque {border:4px solid rgba(36,125,157);}
        #coluna_direita {flex-basis:10%;background-color:#123449;border-radius: 5px;}
        #coluna_direita ul {list-style: none;margin: 0;padding: 0;}
        #coluna_direita li {color:#FFF;}
        .coluna-right {flex-basis:30%;flex-wrap: wrap;border-radius:5px;height:720px;}
        .coluna-right.aba_individual {flex-basis:30%;flex-wrap: wrap;border-radius:5px;height:1000px;}
        /* .container_div_info {background-color:rgba(0,0,0,1);position:absolute;width:500px;right:0px;top:57px;min-height: 700px;display: none;z-index: 1;color: #FFF;} */
        .container_div_info {display:flex;position:absolute;flex-basis:30%;right:0px;top:57px;display: none;z-index: 1;color: #FFF;}
        #padrao {width:50px;background-color:#FFF;color:#000;}
        .buttons {display: flex;}
        .button_individual {display:flex;}
        .button_empresarial {display: flex;}
        .dt-right {text-align: right !important;}
        .dt-center {text-align: center !important;}
        .estilizar_pagination .pagination {font-size: 0.8em !important;color:#FFF;}
        .estilizar_pagination .pagination li {height:10px;color:#FFF;}
        .por_pagina {font-size: 12px !important;color:#FFF;}
        .por_pagina #tabela_mes_atual_length {display: flex;align-items: center;align-self: center;margin-top: 8px;}
        .por_pagina #tabela_mes_diferente_length {display: flex;align-items: center;align-self: center;margin-top: 8px;}
        .por_pagina select {color:#FFF !important;}
        .estilizar_pagination #tabela_mes_atual_previous {color:#FFF !important;}
        .estilizar_pagination #tabela_mes_atual_next {color:#FFF !important;}
        .estilizar_pagination #tabela_mes_diferente_previous {color:#FFF !important;}
        .estilizar_pagination #tabela_mes_diferente_next {color:#FFF !important;}
        #tabela_individual_filter input[type='search'] {background-color: #FFF !important;margin-right:5px;margin-top:3px;}
        #tabela_coletivo_filter input[type='search'] {background-color: #FFF !important;margin-right:5px;margin-top:3px;}
        #tabela_empresarial_filter input[type='search'] {background-color: #FFF !important;}

        #tabela_empresarial td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }

        #tabela_individual td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }

        #tabela_coletivo td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }


        th { font-size: 0.8em !important; }
        td { font-size: 0.7em !important; }


        .select2-container .select2-selection {
            text-align:center !important;
        }

        

        
    





    </style>
@stop




