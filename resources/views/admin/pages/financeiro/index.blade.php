@extends('adminlte::page')
@section('title', 'Financeiro')
@section('plugins.Sweetalert2',true)
@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('content_top_nav_right')
    <li class="bg-white rounded" style="padding:1px;">
        <a class="text-white nav-link" href="{{route('orcamento.search.home')}}">Tabela de Preço</a>
    </li>
{{--    <li class="bg-white rounded" style="padding:1px;">--}}
{{--        <a class="text-white nav-link" href="{{route('home.administrador.consultar')}}">Consultar</a>--}}
{{--    </li>--}}
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

    <div class="modal fade" id="atualizarModal" tabindex="-1" aria-labelledby="atualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="atualizarModalLabel">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="formulario_atualizar" id="formulario_atualizar" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <label for="arquivo">Arquivo:</label>
                                <input type="file" name="arquivo_atualizar" id="arquivo_atualizar" class="form-control form-control-sm">
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

    <div class="modal fade" id="uploadCancelados" tabindex="-1" aria-labelledby="uploadCanceladosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCanceladosLabel">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="formulario_cancelados" id="formulario_cancelados" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <div style="flex-basis:90%;margin-right:2%;">
                                <label for="arquivo_cancelados">Arquivo:</label>
                                <input type="file" name="arquivo_cancelados" id="arquivo_cancelados" class="form-control form-control-sm">
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
                        <button class="btn btn-block btn-info" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:100%;">Arquivos</button>
                    </div>

                    <div class="d-flex justify-content-between mb-1">
                        <span class="btn btn-upload" style="background-color:#123449;color:#FFF;font-size:0.875em;flex-basis:30%;">Upload</span>
                        <span class="btn btn-atualizar" style="background-color:#123449;color:#FFF;font-size:0.875em;flex-basis:30%;margin:0 1%;">Atualizar</span>
                        <span class="btn btn-cancelados" style="background-color:#123449;color:#FFF;font-size:0.875em;flex-basis:30%;">Cancelados</span>
                    </div>

                    <div class="d-flex justify-content-between mb-1">
                        <a class="btn btn-block btn-info" href="{{route('contratos.create')}}" style="background-color:#123449;color:#FFF;font-size:1.2em;flex-basis:100%;">Cadastrar</a>
                    </div>




                    <div class="mb-1 destaque_content" id="content_list_individual_begin">

                        <div class="d-flex justify-content-around" style="flex-wrap:wrap;">

                            <div style="display:flex;flex-basis:100%;justify-content:center;border-bottom:2px solid white;margin-bottom:5px;padding:5px 0;">
                                <p style="margin:0;padding:0;">Listagem(Completa)</p>
                            </div>



                            <div style="display:flex;flex-basis:48%;height:35px;margin-right:1%;">
                                <select id="mudar_ano_table" class="form-control" style="height:100%;font-size:0.8em;">

                                </select>
                            </div>

                            <div style="display:flex;flex-basis:48%;height:35px;">
                                <select id="mudar_mes_table" class="form-control" style="height:100%;font-size:0.8em;">

                                </select>
                            </div>

                            <div style="margin:20px 0;"></div>

                            <div style="height:30px;display:flex;flex-basis:99%;">
                                <select style="height:100%;display:flex;flex-basis:100%;margin-right:2%;width:100%;" id="select_usuario_individual" class="form-control">
                                    <option value="todos" class="text-center" data-id="0">---Escolher Corretor---</option>
                                </select>
                            </div>

                        </div>

                        <div style="margin:15px 0;"></div>

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
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:1px;">
                                <span>Atrasados</span>
                                <span class="badge badge-light individual_quantidade_atrasado" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>
                        </ul>
                    </div>
                    <div style="background-color:#123449;border-radius:5px;margin-bottom:3px;">
                        <ul style="list-style:none;margin:0;padding:6px 0;" id="finalizado_corretor">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:1px;" id="aguardando_pagamento_6_parcela_individual" class="individual">
                                <span>Finalizado</span>
                                <span class="badge badge-light individual_quantidade_6_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>
                        </ul>
                    </div>
                    <div style="background-color:#123449;border-radius:5px;margin-bottom:3px;">
                        <ul style="list-style:none;margin:0;padding:6px 0;" id="cancelado_corretor">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:1px;" id="cancelado_individual" class="individual">
                                <span>Cancelados</span>
                                <span class="badge badge-light individual_quantidade_cancelado" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>
                        </ul>
                    </div>
                    <div style="margin:0 0 5px 0;padding:0;background-color:#123449;border-radius:5px;">
                        <ul style="margin:0;padding:0;list-style:none;" id="listar_individual">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:1px;" id="aguardando_pagamento_1_parcela_individual" class="individual">
                                <span>Pag. 1º Parcela</span>
                                <span class="badge badge-light individual_quantidade_1_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>


                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:2px;" id="aguardando_pagamento_2_parcela_individual" class="individual">
                                <span>Pag. 2º Parcela</span>
                                <span class="badge badge-light individual_quantidade_2_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>

                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:2px;" id="aguardando_pagamento_3_parcela_individual" class="individual">
                                <span>Pag. 3º Parcela</span>
                                <span class="badge badge-light individual_quantidade_3_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>

                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:2px;" id="aguardando_pagamento_4_parcela_individual" class="individual">
                                <span>Pag. 4º Parcela</span>
                                <span class="badge badge-light individual_quantidade_4_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
                            </li>

                            <li style="padding:0px 3px;display:flex;justify-content:space-between;margin-bottom:2px;margin-top:2px;" id="aguardando_pagamento_5_parcela_individual" class="individual">
                                <span>Pag. 5º Parcela</span>
                                <span class="badge badge-light individual_quantidade_5_parcela" style="width:45px;text-align:right;display:flex;align-items:center;justify-content:right;">0</span>
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

                                <th>Data Nasc.</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Rua</th>
                                <th>Cep</th>
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

                                        <option value="2023">2023</option>

                                </select>
                            </div>
                            <div style="display:flex;flex-basis:48%;margin-bottom:1%;">
                                <select id="mudar_mes_table_coletivo" class="form-control">
                                    <option value="00" class="text-center">-Meses-</option>

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
                            <select class="form-control" style="flex-basis:98%;" id="select_usuario">
                                <option value="todos" class="text-center">---Escolher Corretor---</option>

                            </select>
                            <div style="margin-top:2px;height:2px;display:flex;flex-basis:98%;"></div>

                            <select class="my-1 form-control" style="flex-basis:98%;margin-top:20px;" id="select_coletivo_administradoras">
                                <option value="todos" class="text-center">---Administradora---</option>

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

                                <th>Data Nasc.</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Rua</th>
                                <th>Cep</th>
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


                    <div class="mb-1 mt-1 py-2" style="background-color:#123449;border-radius:5px;margin-bottom:3px;" id="content_list_empresarial_begin">

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

                            </select>

                            <select style="flex-basis:98%;" name="mudar_planos_empresarial" id="mudar_planos_empresarial" class="form-control my-2 mx-auto">
                                <option value="todos" class="text-center" data-id="0">---Escolher Planos---</option>

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
                                <span class="badge badge-light empresarial_quantidade_atrasado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>

                    <div style="border-radius:5px;margin:1px 0;background-color:#123449;">
                        <ul style="list-style:none;margin:0;padding:5px 0;" id="finalizado_corretor_empresarial">
                            <li style="padding:0px 3px;display:flex;justify-content:space-between;" id="" class="empresarial">
                                <span>Finalizado</span>
                                <span class="badge badge-light quantidade_empresarial_finalizado" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>


                    <div style="margin:0 0 5px 0;padding:5px 0 0 0;background-color:#123449;border-radius:5px;">

                        <ul style="margin:0;padding:0;list-style:none;" id="listar_empresarial">

                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_em_analise_empresarial"  class="empresarial">
                                <span>Em Análise</span>
                                <span class="badge badge-light empresarial_quantidade_em_analise" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_1_parcela_empresarial" class="empresarial">
                                <span>Pag. 1º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_1_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_2_parcela_empresarial" class="empresarial">
                                <span>Pag. 2º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_2_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_3_parcela_empresarial" class="empresarial">
                                <span>Pag. 3º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_3_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_4_parcela_empresarial" class="empresarial">
                                <span>Pag. 4º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_4_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_5_parcela_empresarial" class="empresarial">
                                <span>Pag. 5º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_5_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" id="aguardando_pagamento_6_parcela_empresarial" class="empresarial">
                                <span>Pag. 6º Parcela</span>
                                <span class="badge badge-light empresarial_quantidade_6_parcela" style="width:45px;text-align:right;">0</span>
                            </li>
                        </ul>
                    </div>


                    <div style="background-color:#123449;border-radius:5px;">
                        <ul style="list-style:none;margin:0;padding:10px 0;" id="aguardando_cancelado_empresarial">
                            <li style="padding:0px 5px;display:flex;justify-content:space-between;margin-bottom:5px;" class="empresarial">
                                <span>Cancelado</span>
                                <span class="badge badge-light empresarial_quantidade_cancelado" style="width:45px;text-align:right;">0</span>
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
                                <th>Resposta</th>
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

            if (window.location.hash) {
                var tabelaID = window.location.hash.substring(1);
                $('#' + tabelaID).DataTable().state.load();
            }

            $(".btn-cancelados").on('click',function(){
               $("#uploadCancelados").modal('show');
            });




            let url = window.location.href.indexOf("?");
            if(url != -1) {

                var b =  window.location.href.substring(url);
                var alvo = b.split("=")[1].split("&")[0];


                if(alvo == "coletivo") {

                    $('.list_abas li').removeClass('ativo');
                    $('.list_abas li:nth-child(2)').addClass("ativo");
                    $('.conteudo_abas main').addClass('ocultar');
                    $('#aba_coletivo').removeClass('ocultar');
                    //var c = window.location.href.replace(b,"");
                    //window.history.pushState({path:c},'',c);
                    inicializarColetivo();
                    //$("#janela_atual").val("aba_coletivo");
                }
                if(alvo == "empresarial") {

                    $('.list_abas li').removeClass('ativo');
                    $('.list_abas li:nth-child(3)').addClass("ativo");
                    $('.conteudo_abas main').addClass('ocultar');
                    $("#aguardando_em_analise_empresarial").addClass("text");
                    $("#aguardando_em_analise_empresarial").addClass('textoforte-list');
                    $('#aba_empresarial').removeClass('ocultar');
                    var c = window.location.href.replace(b,"");
                    window.history.pushState({path:c},'',c);
                    inicializarEmpresarial();

                }
            }





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

                    inicializarIndividual();



                    // $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    // $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // tableempresarial.ajax.url('{{route("financeiro.zerar.financeiro")}}').load();



                    //$("#mudar_mes_table_coletivo").val("00");
                    //$("#select_usuario").val('todos');
                    //$("#select_coletivo_administradoras").val('todos');

                    //$("#select_usuario").trigger('change');



                } else if($(this).attr('data-id') == "aba_coletivo") {






                    // $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table_individual.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    // $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // tableempresarial.ajax.url('{{route("financeiro.zerar.financeiro")}}').load();

                    inicializarColetivo();

                    //

                    $('#mudar_mes_table').find('option').eq(0).prop('selected', true);


                    // $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table.ajax.url("{{ route('financeiro.coletivo.em_geral') }}").load();

                } else {

                    inicializarEmpresarial();
                    // $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    // $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem</h4>");
                    // table_individual.ajax.url("{{ route('financeiro.zerar.financeiro') }}").load();

                    // $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                    // tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.listarContratoEmpresaPendentes")}}').load();

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

                if ($.fn.DataTable.isDataTable('.listardados')) {
                    $('.listardados').DataTable().destroy();
                }

                table = $(".listardados").DataTable({
                    //dom: '<"d-flex justify-content-between"<"#title_coletivo_por_adesao_table">ftr><t><"d-flex justify-content-between"lp>',
                    dom: '<"d-flex justify-content-between"<"#title_individual">Bftr><t><"d-flex justify-content-between"lp>',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Exportar para Excel',
                            className: 'btn btn-primary',
                            exportOptions: {
                                //columns: ':visible' // ou selecione as colunas específicas
                                columns: [0,3,2,5,4,6,7,12,13,14,15,16,17,18]
                            }
                        }
                    ],
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
                    //stateSave: true,
                    processing: true,

                    stateSaveCallback: function(settings, data) {
                        // Update the URL with the state
                        let queryString = $.param(data);
                        History.pushState(null, null, '?' + queryString);
                    },
                    stateLoadCallback: function(settings) {
                        // Load the state from the URL
                        var queryString = location.search.substr(1);
                        return $.deparam(queryString);
                    },
                    ajax: {
                        "url":"{{ route('financeiro.coletivo.em_geral') }}",
                        "dataSrc": ""
                    },
                    "lengthMenu": [1000,2000],
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
                        {data:"resposta",name:"resposta",visible:false},
                        {data:"nascimento",name:"nascimento",visible:false},
                        {data:"fone",name:"fone",visible:false},
                        {data:"email",name:"email",visible:false},
                        {data:"cidade",name:"cidade",visible:false},
                        {data:"bairro",name:"bairro",visible:false},
                        {data:"rua",name:"rua",visible:false},
                        {data:"cep",name:"cep",visible:false},
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


                        let corretoresUnicos = new Set();
                        this.api().column(2).data().each(function(v) {
                            corretoresUnicos.add(v);
                        });
                        let corretoresOrdenados = Array.from(corretoresUnicos).sort();
                        $('#select_usuario').empty();
                        $('#select_usuario').append('<option value="todos">-- Escolher Corretor --</option>');
                        corretoresOrdenados.forEach(function(corretor) {
                            $('#select_usuario').append('<option value="' + corretor + '">' + corretor + '</option>');
                        });

                        let anos = this.api().column(0).data().toArray().map(function(value) {
                            let year = new Date(value).getFullYear();
                            return !isNaN(year) ? year : null;
                        });
                        let anosUnicos = new Set(anos.filter(function(ano) {return ano !== null;}));


                        let selectAno = $('#mudar_ano_table_coletivo');
                        selectAno.empty(); // Limpar opções existentes
                        selectAno.append('<option value="" selected>- Ano -</option>'); // Opção padrão
                        anosUnicos.forEach(function(ano) {
                            selectAno.append('<option value="' + ano + '">' + ano + '</option>');
                        });


                        let administradoras = new Set();
                        this.api().column(4).data().each(function(v) {
                            administradoras.add(v);
                        });
                        let adminOrdenados = Array.from(administradoras).sort();
                        $('#select_coletivo_administradoras').empty();
                        $('#select_coletivo_administradoras').append('<option value="todos">-- Administradoras --</option>');
                        adminOrdenados.forEach(function(corretor) {
                            $('#select_coletivo_administradoras').append('<option value="' + corretor + '">' + corretor + '</option>');
                        });
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
                $('.dataTables_filter input')
                    .unbind()
                    .bind('keyup', function(e) {
                        //console.log(this.value);
                        if (e.keyCode == 13 || this.value.length >= 3 || this.value.length == 0) {
                            table.search(this.value).draw();
                            var pesquisaQuery = table.search();
                            var url = new URL(window.location);
                            url.searchParams.set('search', pesquisaQuery);
                            window.history.pushState({}, '', url);
                        }
                    });
            }

            $('.dataTables_filter input').on('input', function() {

                if ($(this).val() === '') {

                    inicializarColetivo();
                }
            });







            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }

            // Capturar o parâmetro de pesquisa da URL
            var searchQuery = getUrlParameter('search');

            if (searchQuery) {
                table.search(searchQuery).draw();
                $('.dataTables_filter input').val(searchQuery);
            }


            $('#tabela_coletivo').on('click', 'tbody tr', function () {
                table.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
            });

            function inicializarIndividual() {

                if($.fn.DataTable.isDataTable('.listarindividual')) {
                    $('.listarindividual').DataTable().destroy();

                }

               $(".listarindividual").DataTable({
                    //dom: '<"d-flex justify-content-between"<"#title_individual">ftr><t><"d-flex justify-content-between"lp>',
                   dom: '<"d-flex justify-content-between"<"#title_individual">Bftr><t><"d-flex justify-content-between"lp>',
                   buttons: [
                       {
                           extend: 'excelHtml5',
                           text: 'Exportar para Excel',
                           className: 'btn btn-primary',
                           exportOptions: {
                               //columns: ':visible' // ou selecione as colunas específicas
                               columns: [0,4,5,6,3,14,0,13,15,16,17,18]
                           }
                       }
                   ],
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
                        {data:"status",name:"status"},
                        {data:"data_nascimento",name:"data_nascimento"},
                        {data:"fone",name:"fone"},
                        {data:"email",name:"email"},
                        {data:"cidade",name:"cidade"},
                        {data:"bairro",name:"bairro"},
                        {data:"rua",name:"rua"},
                        {data:"cep",name:"cep"},


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
                        {"targets": 11,"visible":false},
                        {"targets": 12,"visible":false},
                        {"targets": 13,"visible":false},
                        {"targets": 14,"visible":false},
                        {"targets": 15,"visible":false},
                        {"targets": 16,"visible":false},
                        {"targets": 17,"visible":false},
                        {"targets": 18,"visible":false},
                    ],
                    "initComplete": function( settings, json ) {

                        $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completasss)</h4>");
                        let countPagamento1 = this.api().column(9).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                        let countPagamento2 = this.api().column(9).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                        let countPagamento3 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                        let countPagamento4 = this.api().column(9).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                        let countPagamento5 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                        let countPagamento6 = this.api().column(9).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                        let finalizado = this.api().column(9).data().filter((value, index) => value === 'Finalizado').length;
                        let countCancelados = this.api().column(9).data().filter((value, index) =>  value === 'Cancelado').length;

                        let countAprovado = this.api().column(11).data().filter((value, index) =>  value === 'Aprovado').length;

                        let countAtrasadoTeste = this.api().rows().count(); // Inicialmente, contamos todas as linhas
                        countAtrasadoTeste = countAtrasadoTeste - countPagamento6 - finalizado - countCancelados - countAprovado;

                        //let countAtrasado = this.api().column(11).data().filter((value, index) => value === 'Atrasado').length;

                        let tablein = $('.listarindividual').DataTable();


                        //console.log(countAtrasadoTeste);

                        $(".individual_quantidade_1_parcela").text(countPagamento1);
                        $(".individual_quantidade_2_parcela").text(countPagamento2);
                        $(".individual_quantidade_3_parcela").text(countPagamento3);
                        $(".individual_quantidade_4_parcela").text(countPagamento4);
                        $(".individual_quantidade_5_parcela").text(countPagamento5);
                        $(".individual_quantidade_6_parcela").text(finalizado);
                        $(".individual_quantidade_cancelado").text(countCancelados);
                        $(".individual_quantidade_atrasado").text(countAtrasadoTeste);

                        let corretoresUnicos = new Set();
                        this.api().column(2).data().each(function(v) {
                            corretoresUnicos.add(v);
                        });
                        let corretoresOrdenados = Array.from(corretoresUnicos).sort();
                        $('#select_usuario_individual').empty();
                        $('#select_usuario_individual').append('<option value="todos">-- Escolher Corretor --</option>');
                        corretoresOrdenados.forEach(function(corretor) {
                            $('#select_usuario_individual').append('<option value="' + corretor + '">' + corretor + '</option>');
                        });

                        let anos = this.api().column(0).data().toArray().map(function(value) {
                            let year = new Date(value).getFullYear();
                            return !isNaN(year) ? year : null;
                        });
                        let anosUnicos = new Set(anos.filter(function(ano) {return ano !== null;}));

                        let selectAno = $('#mudar_ano_table');
                        selectAno.empty(); // Limpar opções existentes
                        selectAno.append('<option value="" selected>- Ano -</option>'); // Opção padrão
                        anosUnicos.forEach(function(ano) {
                            selectAno.append('<option value="' + ano + '">' + ano + '</option>');
                        });

                        /*
                        let meses = this.api().column(0).data().toArray().map(function(value) {
                            let month = new Date(value).getMonth();
                            return !isNaN(month) ? month : null; // Ignorar valores nulos e não numéricos
                        });

                        let mesesUnicos = new Set(meses.filter(function(mes) {
                            return mes !== null; // Remover valores nulos
                        }));

                        let mesesOrdenados = Array.from(mesesUnicos).sort(function(a, b) {
                            return a - b;
                        });





                        let selectMes = $('#mudar_mes_table');
                        selectMes.empty(); // Limpar opções existentes
                        selectMes.append('<option value="" selected>- Mês -</option>'); // Opção padrão
                        let nomesMeses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
                        mesesOrdenados.forEach(function(mes) {
                            selectMes.append('<option value="' + (mes + 1) + '">' + nomesMeses[mes] + '</option>');
                        });

                        */


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




            var tableempresarial;
            function inicializarEmpresarial() {

                if($.fn.DataTable.isDataTable('.listarempresarial')) {
                    $('.listarempresarial').DataTable().destroy();
                }

                tableempresarial = $(".listarempresarial").DataTable({
                    dom: '<"d-flex justify-content-between"<"#title_empresarial">ftr><t><"d-flex justify-content-between"lp>',
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
                        "lengthMenu": "Exibir _MENU_ por página",
                        "zeroRecords": "Nenhum registro encontrado"
                    },
                    ajax: {
                        "url":"{{ route('contratos.listarEmpresarial.listarContratoEmpresaPendentes') }}",
                        "dataSrc": ""
                    },
                    "lengthMenu": [1000,2000,3000],
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
                        {data:"status",name:"status",width:"10%"},
                        {data:"id",name:"id",width:"5%"},
                        {data:"resposta",name:"resposta",width:"10%",visible:false}
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
                        $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Listagem(Completa)</h4>");
                        let corretoresUnicos = new Set();
                        this.api().column(2).data().each(function(v) {
                            corretoresUnicos.add(v);
                        });
                        let corretoresOrdenados = Array.from(corretoresUnicos).sort();
                        $('#mudar_user_empresarial').empty();
                        $('#mudar_user_empresarial').append('<option value="todos">-- Escolher Corretor --</option>');
                        corretoresOrdenados.forEach(function(corretor) {
                            $('#mudar_user_empresarial').append('<option value="' + corretor + '">' + corretor + '</option>');
                        });

                        let planosAdmin = new Set();
                        this.api().column(7).data().each(function(v) {
                            planosAdmin.add(v);
                        });
                        let planosOrdenados = Array.from(planosAdmin).sort();
                        $('#mudar_planos_empresarial').empty();
                        $('#mudar_planos_empresarial').append('<option value="todos">-- Escolher Planos --</option>');
                        planosOrdenados.forEach(function(corretor) {
                            $('#mudar_planos_empresarial').append('<option value="' + corretor + '">' + corretor + '</option>');
                        });

                        let countEmAnalise  = this.api().column(9).data().filter((value, index) => value === 'Em Análise').length;
                        let countPagamento1 = this.api().column(9).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                        let countPagamento2 = this.api().column(9).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                        let countPagamento3 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                        let countPagamento4 = this.api().column(9).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                        let countPagamento5 = this.api().column(9).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                        let countPagamento6 = this.api().column(9).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                        let countAtrasado   = this.api().column(11).data().filter((value, index) => value === 'Atrasado').length;
                        let countCancelados = this.api().column(9).data().filter((value, index) =>  value === 'Cancelado').length;
                        let countFinalizado = this.api().column(9).data().filter((value, index) =>  value === 'Finalizado').length;
                        $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                        $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                        $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                        $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                        $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                        $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                        $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                        $(".empresarial_quantidade_cancelado").text(countCancelados);
                        $(".quantidade_empresarial_finalizado").text(countFinalizado);
                        $(".empresarial_quantidade_atrasado").text(countAtrasado);

                        let anos = this.api().column(0).data().toArray().map(function(value) {
                            let year = new Date(value).getFullYear();
                            return !isNaN(year) ? year : null;
                        });
                        let anosUnicos = new Set(anos.filter(function(ano) {return ano !== null;}));


                        let selectAno = $('#mudar_ano_table_empresarial');
                        selectAno.empty(); // Limpar opções existentes
                        selectAno.append('<option value="" selected>- Ano -</option>'); // Opção padrão
                        anosUnicos.forEach(function(ano) {
                            selectAno.append('<option value="' + ano + '">' + ano + '</option>');
                        });





                    },
                    "drawCallback":function(settings) {

                    },
                    footerCallback: function (row, data, start, end, display) {
                        let intVal = function (i) {return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;};
                        total = this.api().column(6,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);},0);
                        total_vidas = this.api().column(5,{search: 'applied'}).data().reduce(function (a, b) {return intVal(a) + intVal(b);},0);
                        total_linhas = this.api().column(5,{search: 'applied'}).data().count();
                        let total_br = total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                        $(".total_por_orcamento_empresarial").html(total_linhas);
                        $(".total_por_vida_empresarial").html(total_vidas);
                        $(".total_por_page_empresarial").html(total_br);
                    }
                });


            }

            function inicializarSemCarteirinha() {
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



            }



            $('#tabela_empresarial').on('click', 'tbody tr', function () {
                tableempresarial.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
            });

            $("#mudar_user_empresarial").on('change',function(){
                let user = $(this).val();

                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_empresarial_begin").addClass('destaque_content_radius');

                if(user != "todos") {

                    tableempresarial.column(9).search('').draw();
                    tableempresarial.column(11).search('').draw();
                    tableempresarial.column(2).search(user).draw();

                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);

                } else {
                    tableempresarial.column(2).search('').draw();

                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);



                }

            });

            $("#mudar_planos_empresarial").on('change',function(){
                let plano = $(this).val();

                let user_id = $("#mudar_user_empresarial").val();
                let mes = $("#mudar_mes_table_empresarial").val();
                mes = mes == "00" ? null : mes;
                user_id = user_id == "todos" ? null : user_id;

                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_empresarial_begin").addClass('destaque_content_radius');

                if(plano != "todos") {


                    tableempresarial.column(7).search(plano).draw();


                    if(mes) {
                        let ano = $("#mudar_ano_table_empresarial").val() != null ? $("#mudar_ano_table_empresarial").val() : new Date().getFullYear();
                        let mesAno = mes + '/' + ano;
                        tableempresarial.column(0).search(mesAno,true,false).draw();
                    }

                    if(user_id) {
                        let user_name = $("#mudar_user_empresarial").val();
                        tableempresarial.column(2).search(user_name).draw();
                    }



                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);
                } else {

                    tableempresarial.column(7).search('').draw();
                    if(mes) {
                        let ano = $("#mudar_ano_table_empresarial").val() != null ? $("#mudar_ano_table_empresarial").val() : new Date().getFullYear();
                        let mesAno = mes + '/' + ano;
                        tableempresarial.column(0).search(mesAno,true,false).draw();
                    }

                    if(user_id) {
                        let user_name = $("#mudar_user_empresarial").val();
                        tableempresarial.column(2).search(user_name).draw();
                    }

                    //tableempresarial.column(2).search('').draw();
                    //tableempresarial.column(11).search('').draw();
                    //
                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);
                }
                //
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
                    let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                    let atrasado = 0;
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

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                    $(".coletivo_quantidade_atrasado").text(atrasado);

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


            $("#select_usuario").select2({width:"98%"});
            $("#select_usuario_individual").select2({width:"99.5%"});
            $("#select_coletivo_administradoras").select2({width:"98%"});


            $("#mudar_user_empresarial").select2({width:"98%"});
            $("#mudar_planos_empresarial").select2({width:"98%"});






            function aplicarEstilos() {
                $('.select2-results__option[role="option"]').css({'font-size': '0.8em'});
            }

            $('#select_usuario').on('select2:open', function() {setTimeout(aplicarEstilos,0);});

            $('#select_usuario_individual').on('select2:open', function() {
                setTimeout(aplicarEstilos,0);
            });

            $('#select_usuario').on('select2:select', aplicarEstilos);
            $('#select_usuario_individual').on('select2:select', aplicarEstilos);


            $("#select_usuario").on('change',function(){

                    table.columns().search('').draw();
                    //$.fn.dataTable.ext.search = [];


                    let user_id = $(this).find("option:selected").data("id");
                    let mes = $("#mudar_mes_table_coletivo").val();
                    let ano = $("#mudar_ano_table_coletivo").val() != "" ? $("#mudar_ano_table_coletivo").val() : "00";
                    let admin = $("#select_coletivo_administradoras").val();
                    $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#grupo_finalizados").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#listar li").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#content_list_coletivo_begin").addClass('destaque_content');

                    mes = mes == 00 ? null : mes;
                    admin = admin == "todos" ? null : $("#select_coletivo_administradoras").find("option:selected").data("id");
                    user_id = user_id == undefined ? null : user_id;

                    let corretorSelecionado = $(this).val();
                    //table.search('').draw();
                    if (corretorSelecionado != 'todos') {
                        //table.column(9).search('').draw();
                        //table.column(11).search('').draw();
                        table.column(2).search(corretorSelecionado).draw();
                        let administradora = $("#select_coletivo_administradoras").val();
                        if(administradora != "todos") {
                            table.column(4).search(administradora,true,false).draw();
                        }




                        if(mes != null && ano != null) {

                            let mesAno = mes+"/"+ano;
                            console.log(mesAno);
                            table.column(0).search(mesAno,true,false).draw();
                        }



                        let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                        let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                        let atrasado = 0;
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

                        dadosColuna11.each(function (valor) {
                            if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                        $(".coletivo_quantidade_atrasado").text(atrasado);




                    } else {

                        table.column(2).search('').draw();

                        let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                        let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                        let atrasado = 0;
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

                        dadosColuna11.each(function (valor) {
                            if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                        $(".coletivo_quantidade_atrasado").text(atrasado);
                    }
            });

            $('#mudar_ano_table_coletivo').on('change', function() {
                table.columns().search('').draw();
                $.fn.dataTable.ext.search = [];
                let anoSelecionado = $(this).val();
                // Filtrar as linhas da tabela com base no ano selecionado
                table.column(0).search(anoSelecionado).draw();

                let corretorSelecionado = $("#select_usuario").val();
                if(corretorSelecionado != "todos") {
                    table.column(2).search(corretorSelecionado).draw();
                }

                let administradora = $("#select_coletivo_administradoras").val();
                if(administradora != "todos") {
                    table.column(4).search(administradora).draw();
                }

                let mes = $("#mudar_mes_table_coletivo").val();

                if(mes != '00') {
                    let mesAno = mes + '/'+anoSelecionado;
                    table.column(0).search(mesAno,true,false).draw();

                }


                //console.log("Olaaaaaaaaaaaaaaaaaaaaaaaa");


                // // Obter as datas filtradas da coluna 0mudar_mes_table_coletivo
                // let datasFiltradas = table.column(0, { search: 'applied' }).data().toArray();
                //
                // // Obter os meses das datas filtradas
                // let mesesPorAno = datasFiltradas.map(function(value) {
                //     // Converter o formato da data para "YYYY-MM-DD"
                //     let partesData = value.split('/');
                //     let dataFormatada = partesData[2] + '-' + partesData[1] + '-' + partesData[0];
                //     // Obter o mês (1-12) da data formatada
                //     return new Date(dataFormatada).getMonth() + 1;
                // });
                //
                //
                // console.log("mesesPorAno "+mesesPorAno);
                //
                //
                //
                //
                // // Filtrar apenas os meses únicos
                // mesesPorAno = [...new Set(mesesPorAno)];
                // let mesesOrdenados = Array.from(mesesPorAno).sort(function(a, b) {
                //     return a - b;
                // });
                //
                // // // Preencher o select de meses
                // let selectMes = $('#mudar_mes_table_coletivo');
                // selectMes.empty(); // Limpar opções existentes
                // selectMes.append('<option value="" selected>- Mês -</option>'); // Opção padrão
                // let nomesMeses = {
                //     '1': "Janeiro",
                //     '2': "Fevereiro",
                //     '3': "Março",
                //     '4': "Abril",
                //     '5': "Maio",
                //     '6': "Junho",
                //     '7': "Julho",
                //     '8': "Agosto",
                //     '9': "Setembro",
                //     '10': "Outubro",
                //     '11': "Novembro",
                //     '12': "Dezembro"
                // };
                // mesesOrdenados.forEach(function(mes) {
                //     selectMes.append('<option value="' + (mes) + '">' + nomesMeses[mes] + '</option>');
                // });

                let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                let atrasado = 0;
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
                dadosColuna11.each(function (valor) {
                    if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                $(".coletivo_quantidade_atrasado").text(atrasado);
            });

            $('#mudar_ano_table_empresarial').on('change', function() {
                tableempresarial.columns().search('').draw();
                $.fn.dataTable.ext.search = [];

                let corretorSelecionado = $("#mudar_user_empresarial").val();
                if(corretorSelecionado != "todos") {
                    tableempresarial.column(2).search(corretorSelecionado).draw();
                }

                let planoSelecionado = $("#mudar_planos_empresarial").val();
                if(planoSelecionado != "todos") {
                    tableempresarial.column(7).search(planoSelecionado).draw();
                }

                let anoSelecionado = $(this).val();
                tableempresarial.column(0).search(anoSelecionado).draw();





            });













            $('#mudar_ano_table').on('change', function() {
                let anoSelecionado = $(this).val();

                // Filtrar as linhas da tabela com base no ano selecionado
                table_individual.column(0).search(anoSelecionado).draw();

                // Obter as datas filtradas da coluna 0
                let datasFiltradas = table_individual.column(0, { search: 'applied' }).data().toArray();

                // Obter os meses das datas filtradas
                let mesesPorAno = datasFiltradas.map(function(value) {
                    // Converter o formato da data para "YYYY-MM-DD"
                    let partesData = value.split('/');
                    let dataFormatada = partesData[2] + '-' + partesData[1] + '-' + partesData[0];
                    // Obter o mês (1-12) da data formatada
                    return new Date(dataFormatada).getMonth() + 1;
                });

                // Filtrar apenas os meses únicos
                mesesPorAno = [...new Set(mesesPorAno)];
                let mesesOrdenados = Array.from(mesesPorAno).sort(function(a, b) {
                    return a - b;
                });

                // // Preencher o select de meses
                let selectMes = $('#mudar_mes_table');
                selectMes.empty(); // Limpar opções existentes
                selectMes.append('<option value="" selected>- Mês -</option>'); // Opção padrão
                let nomesMeses = {
                            '1': "Janeiro",
                            '2': "Fevereiro",
                            '3': "Março",
                            '4': "Abril",
                            '5': "Maio",
                            '6': "Junho",
                            '7': "Julho",
                            '8': "Agosto",
                            '9': "Setembro",
                            '10': "Outubro",
                            '11': "Novembro",
                            '12': "Dezembro"
                        };
                mesesOrdenados.forEach(function(mes) {
                    //console.log(mes);
                    selectMes.append('<option value="' + (mes) + '">' + nomesMeses[mes] + '</option>');
                });

            });




            var mes_old = "";
            $("#mudar_mes_table").on('change',function(){

                $("#select_usuario_individual").val('');
                $("#corretor_selecionado_id").val('');
                let mes = $(this).val() != "" ? $(this).val() : "00";
                let ano = $("#mudar_ano_table").val() != "" ? $("#mudar_ano_table").val() : "00";


                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#content_list_individual_begin").addClass('destaque_content_radius');
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");

                if(mes != 00) {
                    table_individual.search('').columns().search('').draw();
                    //let mesAno = mes + '/' + new Date().getFullYear();
                    let mesAno = mes + '/'+ano;
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
                        if (valor.toLowerCase() == 'finalizado') {sextaParcelaIndividual++;}
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
            });

            function totalMes() {
                return $("#select_usuario_individual").val();
            }








            $("#mudar_mes_table_coletivo").on('change',function(){
                let mes = $(this).val();

                //table.columns().search('').draw();
                //$.fn.dataTable.ext.search = [];

                $("ul#listar li.coletivo").removeClass('textoforte-list');
                $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                $("#finalizado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#grupo_finalizados").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#listar li").removeClass('destaque_content');
                $("#content_list_coletivo_begin").addClass('destaque_content_radius');
                $("#atrasado_corretor_coletivo").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");

                if(mes != 00) {

                    let ano = $("#mudar_ano_table_coletivo").val();
                    table.search('').columns().search('').draw();
                    let mesAno = mes + '/' + ano;
                    table.column(0).search(mesAno, true, false).draw();

                    let corretorSelecionado = $("#select_usuario").val();

                    let dadosColuna2 = table.column(2,{search: 'applied'}).data().toArray();

                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    $("#select_usuario").empty();
                    //
                    // // Adicionar a opção padrão
                    $("#select_usuario").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');

                    if (corretorSelecionado != "todos" && !nomesUnicos.has(corretorSelecionado)) {
                        nomesUnicos.add(corretorSelecionado); // Adiciona o nome se ele não estiver no conjunto
                    }
                    nomesUnicos.forEach((nome, index) => {
                        let selecao = nome == corretorSelecionado ? 'selected' : '';
                        $("#select_usuario").append(`<option value="${nome}" ${selecao} data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });
                    //Inicializar o select2 novamente
                    $("#select_usuario").select2();

                    if(corretorSelecionado != "todos") {
                        table.column(2).search(corretorSelecionado).draw();
                    }

                    let administradora = $("#select_coletivo_administradoras").val();
                    if(administradora != "todos") {
                        table.column(4).search(administradora).draw();
                    }

                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                    let atrasado = 0;
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
                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                    $(".coletivo_quantidade_atrasado").text(atrasado);
                } else {

                    table.search('').columns().search('').draw();
                    let dadosColuna2 = table.column(2,{search: 'applied'}).data().toArray();

                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);


                    let corretorSelecionado = $("#select_usuario").val();
                    if(corretorSelecionado != "todos") {
                        table.column(2).search(corretorSelecionado).draw();
                    }

                    let administradora = $("#select_coletivo_administradoras").val();
                    if(administradora != "todos") {
                        table.column(4).search(administradora).draw();
                    }

                    let anoSelecionado = $("#mudar_ano_table_coletivo").val();
                    let regex = '\\b' + anoSelecionado + '\\b';
                    // Aplicar o filtro na coluna 0 usando a expressão regular
                    table.column(0).search(regex, true, false).draw();

                    $("#select_usuario").empty();

                    // Adicionar a opção padrão
                    $("#select_usuario").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');

                    // Adicionar as opções ordenadas ao select
                    nomesUnicos.forEach((nome, index) => {
                        let selecao = nome == corretorSelecionado ? 'selected' : '';
                        $("#select_usuario").append(`<option value="${nome}" ${selecao} data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });


                    // Inicializar o select2 novamente
                    $("#select_usuario").select2();

                    let dadosColuna9 = table.column(9,{search: 'applied'}).data();
                    let dadosColuna11 = table.column(11,{search: 'applied'}).data();
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
                    let atrasado = 0;
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
                        if (valor.toLowerCase() == 'atrasado') {atrasado++;}

                    });

                    dadosColuna11.each(function (valor) {
                        if (valor.toLowerCase() == 'atrasado') {atrasado++;}
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
                    $(".coletivo_quantidade_atrasado").text(atrasado);

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

            $("#arquivo_cancelados").on('change',function(){
                let files = $('#arquivo_cancelados')[0].files;
                let load = $(".ajax_load");
                // let file = $(this).val();
                let fd = new FormData();
                fd.append('file',files[0]);
                // fd.append('file',e.target.files[0]);
                $.ajax({
                    url:"{{route('financeiro.sincronizar.cancelados')}}",
                    method:"POST",
                    data:fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        //load.fadeIn(200).css("display", "flex");
                        //$('#uploadModal').modal('hide');
                    },
                    success:function(res) {
                        if(res == "sucesso") {
                           window.location.reload();
                        }

                    }
                });



            });


            $("#arquivo_atualizar").on('change',function(){
                let files = $('#arquivo_atualizar')[0].files;
                let load = $(".ajax_load");
                // let file = $(this).val();
                let fd = new FormData();
                fd.append('file',files[0]);
                // fd.append('file',e.target.files[0]);
                $.ajax({
                    url:"{{route('financeiro.sincronizar.baixas.jaexiste')}}",
                    method:"POST",
                    data:fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#atualizarModal').modal('hide');
                        load.fadeIn(200).css("display", "flex");

                    },
                    success:function(res) {
                        if(res == "successo") {
                            load.fadeOut(200);
                            window.location.reload();
                        }

                    }
                });
            });





            {{--$("#arquivo_atualizar").on('change',function(){--}}

            {{--    let files = $('#arquivo_atualizar')[0].files;--}}
            {{--    let load = $(".ajax_load");--}}
            {{--    // let file = $(this).val();--}}
            {{--    let fd = new FormData();--}}
            {{--    fd.append('file',files[0]);--}}
            {{--    // fd.append('file',e.target.files[0]);--}}
            {{--    $.ajax({--}}
            {{--        url:"{{route('financeiro.sincronizar.baixas.jaexiste')}}",--}}
            {{--        method:"POST",--}}
            {{--        data:fd,--}}
            {{--        contentType: false,--}}
            {{--        processData: false,--}}
            {{--        beforeSend: function () {--}}
            {{--            //load.fadeIn(200).css("display", "flex");--}}
            {{--            //$('#uploadModal').modal('hide');--}}
            {{--        },--}}
            {{--        success:function(res) {--}}
            {{--           if(res == "successo") {--}}
            {{--               window.location.reload();--}}
            {{--           }--}}

            {{--        }--}}
            {{--    });--}}
            {{--});--}}





            $(".btn-atualizar").on('click',function(){

                $("#atualizarModal").modal('show');





                {{--var load = $(".ajax_load");--}}
                {{--$.ajax({--}}
                {{--    url:"{{route('financeiro.sincronizar.baixas.jaexiste')}}",--}}
                {{--    method:"POST",--}}
                {{--    beforeSend: function () {--}}
                {{--        load.fadeIn(200).css("display", "flex");--}}
                {{--    },--}}
                {{--    success:function(res) {--}}
                {{--        window.location.reload();--}}
                {{--    }--}}
                {{--})--}}
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
                            window.location.reload();
                            // load.fadeOut(200);
                            // $('#uploadModal').modal('show');
                            // $(".div_icone_arquivo_upload").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            // $("#arquivo_upload").val('').prop('disabled',true);

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
                        if(res == "sucesso") {
                            load.fadeOut(200);
                            $('#uploadModal').modal('show');
                            $(".div_icone_arquivo_upload").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            $(".div_icone_atualizar_dados").removeClass('btn-danger').addClass('btn-success').html('<i class="far fa-smile-beam fa-lg"></i>');
                            $(".atualizar_dados").removeClass('btn-warning').addClass('btn-secondary').prop('disabled',true);
                            $("#arquivo_upload").val('').prop('disabled',true);
                            window.location.href = response.redirect;
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
                        if (valor.toLowerCase() == 'finalizado') {sextaParcelaIndividual++;}
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

                    table_individual.column(9).search('').draw();

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
                        if (valor.toLowerCase() == 'finalizado') {sextaParcelaIndividual++;}
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

                        }
                    }
                });
                return false;
            });

            $("#mudar_mes_table_empresarial").on('change',function(){

                let mes = $(this).val();
                if(mes != 00) {

                    tableempresarial.search('').columns().search('').draw();
                    let mesAno = mes + '/' + new Date().getFullYear();
                    tableempresarial.column(0).search(mesAno, true, false).draw();

                    let dadosColuna2 = tableempresarial.column(2,{search: 'applied'}).data().toArray();

                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    $("#mudar_user_empresarial").empty();
                    $("#mudar_user_empresarial").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');
                    nomesUnicos.forEach((nome, index) => {
                        $("#mudar_user_empresarial").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });
                    $("#mudar_user_empresarial").select2();


                    let dadosColuna7 = tableempresarial.column(7,{search: 'applied'}).data().toArray();
                    dadosColuna7.sort();
                    let planosUnicos = new Set(dadosColuna7);
                    $("#mudar_planos_empresarial").empty();
                    $("#mudar_planos_empresarial").append('<option value="todos" class="text-center">---Escolher Planos---</option>');
                    planosUnicos.forEach((nome, index) => {
                        $("#mudar_planos_empresarial").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });
                    $("#mudar_planos_empresarial").select2();

                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);

                } else {
                    tableempresarial.search('').columns().search('').draw();
                    let dadosColuna2 = tableempresarial.column(2,{search: 'applied'}).data().toArray();
                    dadosColuna2.sort();
                    let nomesUnicos = new Set(dadosColuna2);
                    $("#mudar_user_empresarial").empty();
                    // Adicionar a opção padrão
                    $("#mudar_user_empresarial").append('<option value="todos" class="text-center">---Escolher Corretor---</option>');
                    // Adicionar as opções ordenadas ao select
                    nomesUnicos.forEach((nome, index) => {
                        $("#mudar_user_empresarial").append(`<option value="${nome}" data-id="${index}" style="font-size:0.5em;">${nome}</option>`);
                    });
                    // Inicializar o select2 novamente
                    $("#mudar_user_empresarial").select2();
                    let planosAdmin = new Set();
                    tableempresarial.column(7).data().each(function(v) {
                        planosAdmin.add(v);
                    });
                    let planosOrdenados = Array.from(planosAdmin).sort();
                    console.log(planosOrdenados);
                    $('#mudar_planos_empresarial').empty();
                    $('#mudar_planos_empresarial').append('<option value="todos">--- Escolher Planos ---</option>');
                    planosOrdenados.forEach(function(corretor) {
                        $('#mudar_planos_empresarial').append('<option value="' + corretor + '">' + corretor + '</option>');
                    });
                    $("#mudar_planos_empresarial").select2();
                    let countEmAnalise  = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Em Análise').length;
                    let countPagamento1 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 1º Parcela').length;
                    let countPagamento2 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 2º Parcela').length;
                    let countPagamento3 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 3º Parcela').length;
                    let countPagamento4 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 4º Parcela').length;
                    let countPagamento5 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Pag. 5º Parcela').length;
                    let countPagamento6 = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) => value === 'Pag. 6º Parcela').length;
                    let countAtrasado   = tableempresarial.column(11,{search: 'applied'}).data().filter((value, index) => value === 'Atrasado').length;
                    let countCancelados = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Cancelado').length;
                    let countFinalizado = tableempresarial.column(9,{search: 'applied'}).data().filter((value, index) =>  value === 'Finalizado').length;
                    $(".empresarial_quantidade_em_analise").text(countEmAnalise);
                    $(".empresarial_quantidade_1_parcela").text(countPagamento1);
                    $(".empresarial_quantidade_2_parcela").text(countPagamento2);
                    $(".empresarial_quantidade_3_parcela").text(countPagamento3);
                    $(".empresarial_quantidade_4_parcela").text(countPagamento4);
                    $(".empresarial_quantidade_5_parcela").text(countPagamento5);
                    $(".empresarial_quantidade_6_parcela").text(countPagamento6);
                    $(".empresarial_quantidade_cancelado").text(countCancelados);
                    $(".quantidade_empresarial_finalizado").text(countFinalizado);
                    $(".empresarial_quantidade_atrasado").text(countAtrasado);
                }
            });

            $("#list_individual_begin").on('click',function(){

                table_individual.column(9).search('').draw();
                let mes = $("#mudar_mes_table").val() == '' || $("#mudar_mes_table").val() == null ? '00' : $("#mudar_mes_table").val();
                let valorSelecionado = $("#select_usuario_individual").val();

                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('destaque_content_radius').removeClass('textoforte-list');
                $("#content_list_individual_begin").addClass('destaque_content_radius');
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Listagem(Completa)</h4>");

                if(mes != 00) {
                    let ano = $("#mudar_ano_table").val();
                    table_individual.search('').columns().search('').draw();
                    let mesAno = mes + '/' + ano;
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
                let dadosColuna00 = table_individual.column(0,{search: 'applied'}).data();



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
                    if (valor.toLowerCase() == 'finalizado') {sextaParcelaIndividual++;}
                    if (valor.toLowerCase() == 'cancelado') {canceladosIndividual++;}

                });

                dadosColuna11.each(function (valor) {
                    if (valor.toLowerCase() == 'atrasado') {atrasadoIndividual++;}
                });

                let countAprovado = dadosColuna11.filter((value, index) =>  value === 'Aprovado').length;

                let total = dadosColuna00.count(); // Inicialmente, contamos todas as linhas

                atrasadoIndividual = total - sextaParcelaIndividual - canceladosIndividual - countAprovado;

                $(".individual_quantidade_1_parcela").text(primeiraParcelaIndividual);
                $(".individual_quantidade_2_parcela").text(segundaParcelaIndividual);
                $(".individual_quantidade_3_parcela").text(terceiraParcelaIndividual);
                $(".individual_quantidade_4_parcela").text(quartaParcelaIndividual);
                $(".individual_quantidade_5_parcela").text(quintaParcelaIndividual);
                $(".individual_quantidade_6_parcela").text(sextaParcelaIndividual);
                $(".individual_quantidade_cancelado").text(canceladosIndividual);
                $(".individual_quantidade_atrasado").text(atrasadoIndividual);
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



            });

            $("#list_empresarial_begin").on('click',function(){

                tableempresarial.column(9).search('').draw();
                tableempresarial.column(11).search('').draw();
                tableempresarial.column(7).search('').draw();

                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_empresarial_begin").addClass('destaque_content_radius');
                //$("#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                //$("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;margin-left:5px;'>Contratos</h4>");
                //tableempresarial.ajax.url('{{route("contratos.listarEmpresarial.listarContratoEmpresaPendentes")}}').load();
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

                    table_individual.column(11).search('').draw();

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

                    table_individual.column(11).search('').draw();

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


                table_individual.column(11).search('').draw();

                table_individual.column(9).search('Finalizado').draw();

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

                    $('.buttons').empty().html();
                    $(".container_edit").addClass('ocultar');
                    $("ul#listar li.coletivo").removeClass('textoforte-list');
                    $("ul#grupo_finalizados li.coletivo").removeClass('textoforte-list');
                    $("#all_pendentes_coletivo").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                } else if(id_lista == "cancelado_coletivo") {
                    $('#title_coletivo_por_adesao_table').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                    table.column(9).search('Cancelado').draw();

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

                tableempresarial.column(9).search('').draw();
                tableempresarial.column(11).search('Atrasado').draw();


                $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#listar_empresarial li").removeClass('textoforte-list').removeClass('destaque_content');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');


            });

            $("#finalizado_corretor_empresarial").on('click',function(){
                tableempresarial.column(9).search('Finalizado').draw();
                $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#listar_empresarial li").removeClass('textoforte-list').removeClass('destaque_content');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');

            });

            $("#atrasado_corretor").on('click',function(){
                $('#title_individual').html("<h4 style='font-size:1em;margin-top:10px;'>Atrasado</h4>");
                table_individual.column(9).search('').draw();
                table_individual.column(11).search('Atrasado').draw();
                table_individual.column(9).search('^(?!.*(?:Cancelado|Finalizado)).*$', true, false).draw();
                $("ul#listar_individual li.individual").removeClass('textoforte-list').removeClass('destaque_content');
                $("#all_pendentes_individual").removeClass('textoforte-list');
                $("ul#grupo_finalizados_individual li.individual").removeClass('textoforte-list');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
                $("#aguardando_pagamento_6_parcela_individual").removeClass('textoforte-list');
                $("#finalizado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#cancelado_corretor").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#content_list_individual_begin").removeClass('destaque_content').removeClass('destaque_content_radius');
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




            });


            $("#aguardando_cancelado_empresarial").on('click',function(){
                $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                tableempresarial.column(9).search('Cancelado').draw();
                $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
            });

            $("#finalizado_corretor_empresarial").on('click',function(){
                $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Cancelado</h4>");
                tableempresarial.column(9).search('Finalizado').draw();
                $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                $(this).addClass('textoforte-list').addClass('destaque_content_radius');
            });




            $("ul#grupo_finalizados_empresarial li.empresarial").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "aguardando_finalizado_empresarial") {
                    $('#title_empresarial').html("<h4 style='font-size:1em;margin-top:10px;'>Finalizado</h4>");
                    tableempresarial.column(9).search('Finalizado').draw();


                    $(".container_edit").addClass('ocultar');
                    $("ul#grupo_finalizados_empresarial li.empresarial").removeClass('textoforte-list');
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list');
                    $(this).addClass('textoforte-list');

                }
            });

            $("ul#listar_empresarial li.empresarial").on('click',function(){
                let id_lista = $(this).attr('id');
                if(id_lista == "aguardando_em_analise_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Em Análise</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Em Análise').draw();

                } else if(id_lista == "aguardando_pagamento_1_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 1º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 1º Parcela').draw();

                } else if(id_lista == "aguardando_pagamento_2_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 2º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 2º Parcela').draw();

                } else if(id_lista == "aguardando_pagamento_3_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 3º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 3º Parcela').draw();

                } else if(id_lista == "aguardando_pagamento_4_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 4º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 4º Parcela').draw();

                } else if(id_lista == "aguardando_pagamento_5_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 5º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 5º Parcela').draw();

                } else if(id_lista == "aguardando_pagamento_6_parcela_empresarial") {
                    $("#title_empresarial").html("<h4 style='font-size:1em;margin-top:10px;'>Pagamento 6º Parcela</h4>");
                    $("ul#listar_empresarial li.empresarial").removeClass('textoforte-list').removeClass('destaque_content');
                    $("#atrasado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#aguardando_cancelado_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#finalizado_corretor_empresarial").removeClass('textoforte-list').removeClass('destaque_content_radius');
                    $("#content_list_empresarial_begin").removeClass('destaque_content_radius');
                    $(this).addClass('textoforte-list').addClass('destaque_content');
                    tableempresarial.column(9).search('Pag. 6º Parcela').draw();

                }  else {

                }
            });
            var contar = 0;


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

        #tabela_empresarial td {white-space: nowrap;overflow: hidden;text-overflow: clip;}
        #tabela_individual td {white-space: nowrap;overflow: hidden;text-overflow: clip;}

        #tabela_coletivo td {white-space: nowrap;overflow: hidden;
            text-overflow: clip;
        }


        th { font-size: 0.8em !important; }
        td { font-size: 0.7em !important; }


        .select2-container .select2-selection {
            text-align:center !important;
        }



        .select2-selection__rendered {
            font-size: 0.8em; /* Tamanho da fonte */
            height: 20px; /* Altura */
            line-height: 20px; /* Espaçamento entre linhas */
            padding: 0 1px; /* Espaçamento interno */

        }

        /* Estilos para a seta de dropdown */
        .select2-selection__arrow {
            height: 20px; /* Altura */
        }






    </style>
@stop




