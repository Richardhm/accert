@extends('adminlte::page')
@section('title', 'Corretora')
@section('content_header')
    <h3 class="text-white">Dados Corretora:</h3>
@stop

@section('content')

    <div class="tab-container border-bottom border-width-2 border-light">
        <div class="tab tab1 active" data-tab="tab1">Dados Corretora</div>
        <div class="tab tab2" data-tab="tab2" style="margin:0 1%;">Comissão Corretora</div>
        <div class="tab tab3" data-tab="tab3">Comissão Corretor</div>
    </div>

    <div class="tab-content active" id="tab1">
        <!-- Conteúdo da primeira aba (Dados Corretora) -->
        <div class="column-wrapper">
            <div class="column column-1">

                <div style="background-color:#123449;padding:5px 3px;border-radius:5px;">
                    <p style="margin:0;padding:0;color:#FFF;">Logo da Corretora</p>
                    <input type="file" id="logo" name="logo" accept="image/*">
                    <div class="imageContainer">
                        <img src="{{asset('camera.png')}}" alt="Camera" id="imgAlt">
                    </div>
                </div>

                <div id="area_atuacao" class="d-flex justify-content-between p-1" style="background-color:#123449;margin:10px 0;flex-basis:100%;flex-wrap: wrap;max-height: 285px;height:285px;overflow: auto;border-radius:5px; ">
                    <div style="margin:0 0 5px 0;padding:0;display:flex;justify-content:space-between;color:#FFF;flex-basis:100%;border-bottom:2px solid white;">
                        <small>Área de Atuação</small>
                        <i class="fas fa-plus fa-sm mt-1"></i>
                    </div>
                    <div style="display: flex;flex-direction: column;">
                        @foreach($cidades as $cc)
                            <p style="color:#FFF;margin:0;padding:0;font-size:0.875em;">{{$cc->nome}}</p>
                        @endforeach
                    </div>

                </div>

            </div>

            <div class="column column-2 p-1">
                <!-- Bloco 2: Formulário -->

                <form id="corretoraForm">
                    <!-- Campo CNPJ -->
                    <span for="cnpj">CNPJ</span>
                    <input type="text" id="cnpj" name="cnpj" style="width: 100%;" class="form-control form-control-sm">

                    <!-- Campo Razão Social -->
                    <span for="razao-social">Razão Social</span>
                    <input type="text" id="razao-social" name="razao-social" style="width: 100%;" class="form-control form-control-sm">

                    <!-- Campos Celular, Telefone e Email -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="celular">Celular</span>
                            <input type="text" id="celular" name="celular" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="telefone">Telefone</span>
                            <input type="text" id="telefone" name="telefone" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;">
                            <span for="email">Email</span>
                            <input type="email" id="email" name="email" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- Campos CEP, Cidade e UF -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="cep">CEP</span>
                            <input type="text" id="cep" name="cep" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="cidade">Cidade</span>
                            <input type="text" id="cidade" name="cidade" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;">
                            <span for="uf">UF</span>
                            <input type="text" id="uf" name="uf" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- Campos Bairro, Rua e Complemento -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="bairro">Bairro</span>
                            <input type="text" id="bairro" name="bairro" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="rua">Rua</span>
                            <input type="text" id="rua" name="rua" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;">
                            <span for="complemento">Complemento</span>
                            <input type="text" id="complemento" name="complemento" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- Campos Localização e Site -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="localizacao">Localização</span>
                            <input type="text" id="localizacao" name="localizacao" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;margin-left:1%;">
                            <span for="site">Site</span>
                            <input type="url" id="site" name="site" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- Campos Instagram, Facebook e LinkedIn -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="instagram">Instagram</span>
                            <input type="url" id="instagram" name="instagram" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="facebook">Facebook</span>
                            <input type="url" id="facebook" name="facebook" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                        <div style="flex: 1;">
                            <span for="linkedin">LinkedIn</span>
                            <input type="url" id="linkedin" name="linkedin" style="width: 100%;" class="form-control form-control-sm">
                        </div>
                    </div>

                    <!-- Botão de Salvar -->
                    <input type="submit" value="Salvar" class="btn btn-info btn-block mt-1">
                </form>
            </div>


            <div class="column column-3" style="background-color:#123449;border-radius:5px;color:#FFF;">
                <!-- Bloco 3: Configuração Orçamento -->
                <p style="margin:0;padding:0;">Configuração Orçamento</p>

                <!-- Bloco 3.1: Plano Individual -->
                <div class="config-block" style="margin-bottom:0;">
                    <p>Plano Individual</p>
                </div>

                <div style="display:flex;margin-bottom:25px;">

                    <div class="columns-1">
                        <div class="d-flex" style="flex-basis:100%;">

                            <div style="display:flex;flex-basis:80%;">
                                <label for="consultasEletivas" style="font-size:0.8em;">Consultas Eletivas</label>
                            </div>
                            <div style="display:flex;flex-basis:20%;">
                                <input type="text" id="consultasEletivas" name="consultasEletivas" style="width:100%;">
                            </div>

                        </div>
                        <div class="d-flex" style="flex-basis:100%;margin:10px 0;">
                            <div style="display:flex;flex-basis:80%;">
                                <label for="consultasUrgencia" style="font-size:0.8em;">Consultas de Urgência</label>
                            </div>
                            <div style="display:flex;flex-basis:20%;">
                                <input type="text" id="consultasUrgencia" name="consultasUrgencia" style="width:100%;">
                            </div>
                        </div>
                        <div class="d-flex" style="flex-basis:100%;">
                            <div style="display:flex;flex-basis:80%;">
                                <label for="examesSimples" style="font-size:0.8em;">Exames Simples</label>
                            </div>
                            <div style="display:flex;flex-basis:20%;">
                                <input type="text" id="examesSimples" name="examesSimples" style="width:100%;">
                            </div>
                        </div>
                        <div class="d-flex" style="flex-basis:100%;margin-top:10px;">
                            <div style="display:flex;flex-basis:80%;">
                                <label for="examesComplexos" style="font-size:0.8em;">Exames Complexos</label>
                            </div>
                            <div style="display:flex;flex-basis:20%;">
                                <input type="text" id="examesComplexos" name="examesComplexos" style="width:100%;">
                            </div>
                        </div>
                    </div>

                    <!-- Bloco direito -->
                    <div class="columns-2">
                        <div class="d-flex" style="flex-basis:100%;">
                            <div style="display:flex;flex-basis:20%;">
                                <label for="linha1" style="font-size:0.8em;">Linha 1</label>
                            </div>
                            <div style="display:flex;flex-basis:80%;">
                                <input type="text" id="linha1" name="linha1" style="width:100%;">
                            </div>

                        </div>
                        <div class="d-flex" style="flex-basis:100%;margin:17px 0;">
                            <div style="display:flex;flex-basis:20%;">
                                <label for="linha2" style="font-size:0.8em;">Linha 2</label>
                            </div>
                            <div style="display:flex;flex-basis:80%;">
                                <input type="text" id="linha2" name="linha2" style="width:100%;">
                            </div>
                        </div>
                        <div class="d-flex" style="flex-basis:100%;">
                            <div style="display:flex;flex-basis:20%;">
                                <label for="linha3" style="font-size:0.8em;">Linha 3</label>
                            </div>
                            <div style="display:flex;flex-basis:80%;">
                                <input type="text" id="linha3" name="linha3" style="width:100%;">
                            </div>
                        </div>
                    </div>



                </div>


                <div style="border:1px solid white;width:100%;height:1px;"></div>


                <!-- Bloco 3.2: Outro Bloco (se houver) -->
                <div class="config-block" style="margin-top:10px;">
                    <div class="config-block">
                        <p>Plano Coletivo</p>
                    </div>

                    <div style="display:flex;">

                        <div class="columns-1">
                            <div class="d-flex" style="flex-basis:100%;">

                                <div style="display:flex;flex-basis:80%;">
                                    <label for="consultasEletivas" style="font-size:0.8em;">Consultas Eletivas</label>
                                </div>
                                <div style="display:flex;flex-basis:20%;">
                                    <input type="text" id="consultasEletivas" name="consultasEletivas" style="width:100%;">
                                </div>

                            </div>
                            <div class="d-flex" style="flex-basis:100%;margin:10px 0;">
                                <div style="display:flex;flex-basis:80%;">
                                    <label for="consultasUrgencia" style="font-size:0.8em;">Consultas de Urgência</label>
                                </div>
                                <div style="display:flex;flex-basis:20%;">
                                    <input type="text" id="consultasUrgencia" name="consultasUrgencia" style="width:100%;">
                                </div>
                            </div>
                            <div class="d-flex" style="flex-basis:100%;">
                                <div style="display:flex;flex-basis:80%;">
                                    <label for="examesSimples" style="font-size:0.8em;">Exames Simples</label>
                                </div>
                                <div style="display:flex;flex-basis:20%;">
                                    <input type="text" id="examesSimples" name="examesSimples" style="width:100%;">
                                </div>
                            </div>
                            <div class="d-flex" style="flex-basis:100%;margin-top:10px;">
                                <div style="display:flex;flex-basis:80%;">
                                    <label for="examesComplexos" style="font-size:0.8em;">Exames Complexos</label>
                                </div>
                                <div style="display:flex;flex-basis:20%;">
                                    <input type="text" id="examesComplexos" name="examesComplexos" style="width:100%;">
                                </div>
                            </div>
                        </div>

                        <!-- Bloco direito -->
                        <div class="columns-2">
                            <div class="d-flex" style="flex-basis:100%;">
                                <div style="display:flex;flex-basis:20%;">
                                    <label for="linha1" style="font-size:0.8em;">Linha 1</label>
                                </div>
                                <div style="display:flex;flex-basis:80%;">
                                    <input type="text" id="linha1" name="linha1" style="width:100%;">
                                </div>

                            </div>
                            <div class="d-flex" style="flex-basis:100%;margin:17px 0;">
                                <div style="display:flex;flex-basis:20%;">
                                    <label for="linha2" style="font-size:0.8em;">Linha 2</label>
                                </div>
                                <div style="display:flex;flex-basis:80%;">
                                    <input type="text" id="linha2" name="linha2" style="width:100%;">
                                </div>
                            </div>
                            <div class="d-flex" style="flex-basis:100%;">
                                <div style="display:flex;flex-basis:20%;">
                                    <label for="linha3" style="font-size:0.8em;">Linha 3</label>
                                </div>
                                <div style="display:flex;flex-basis:80%;">
                                    <input type="text" id="linha3" name="linha3" style="width:100%;">
                                </div>
                            </div>
                        </div>



                    </div>










                </div>
            </div>
        </div>







        </div>


    <div class="tab-content" id="tab2">

        <div id="tab2-content" class="column-wrapper">

            <div class="tab2-content-left">

                <!-- Área de Atuação -->
                <div class="area-atuacao">Área de Atuação</div>

                <!-- Cidades -->
                <div class="cities">
                    <div class="city">Anápolis</div>
                    <div class="city">Goiânia</div>
                    <div class="city">Rondonópolis</div>
                    <div class="city">Cuiabá</div>
                    <div class="city">Três Lagoas</div>
                    <div class="city">Dourados</div>
                    <div class="city">Campo Grande</div>
                    <div class="city">Brasília</div>
                    <div class="city">Rio Verde</div>
                    <div class="city">Bahia</div>
                </div>

                <!-- Opções de Comissão -->
                <div class="comission-options">
                    <div class="option" data-texto="Hapvida">Hapvida</div>
                    <div class="option" data-texto="Coletivo">Coletivo por Adesão</div>
                </div>

                <div class="option-group" id="hapvida-options">
                    <div class="sub-option" data-detail="Plano Individual">Plano Individual</div>
                    <div class="sub-option" data-detail="Plano Individual">Plano Super Simples</div>
                    <div class="sub-option" data-detail="Plano PME">Plano PME</div>
                    <div class="sub-option" data-detail="Plano Corpore">Plano Corpore</div>
                </div>

                <div class="option-group" id="coletivo-options">
                    <div class="sub-option" data-detail="Qualicorp">Qualicorp</div>
                    <div class="sub-option" data-detail="Allcare">Allcare</div>
                    <div class="sub-option" data-detail="Alter">Alter</div>
                    <div class="sub-option" data-detail="Afix">Afix</div>
                </div>




            </div>
            <div class="tab2-content-right">


                <div id="hapvida-table" class="comission-table">
                    <h3 class="title-hap text-center">Hapvida</h3>
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>Parcelas</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>2ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>3ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>4ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>5ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>6ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Coletivo por Adesão - Qualicorp -->
                <div id="coletivo-table" class="comission-table">
                    <h3 class="title-coletivo text-center">Qualicorp</h3>
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>Parcelas</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>2ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>3ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>4ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>5ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>6ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>7ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <div class="tab-content" id="tab3">

        <div id="tab3-content" class="column-wrapper">

            <section id="content_left_comission">
                <div class="comission-type">
                    <button class="btn btn-success mb-1">CLT</button>
                    <button class="btn btn-info">Parceiro</button>
                </div>

                <div id="comission-cities">
                    <div class="city">Anápolis</div>
                    <div class="city">Goiânia</div>
                    <div class="city">Rondonópolis</div>
                    <div class="city">Cuiabá</div>
                    <div class="city">Três Lagoas</div>
                    <div class="city">Dourados</div>
                    <div class="city">Campo Grande</div>
                    <div class="city">Brasília</div>
                    <div class="city">Rio Verde</div>
                    <div class="city">Bahia</div>
                </div>

                <div id="hapvida-options-comissions">
                    <div class="option" data-plan-detail="hapvida">Hapvida</div>
                    <div class="option" data-plan-detail="coletivo">Coletivo por Adesão</div>
                </div>

                <div id="hapvida-options-comissions-planos" class="options-comissions-table">
                    <div class="option" data-detail-plan="Plano Individual">Plano Individual</div>
                    <div class="option" data-detail-plan="Plano Super Simples">Plano Super Simples</div>
                    <div class="option" data-detail-plan="Plano PME">Plano PME</div>
                    <div class="option" data-detail-plan="Plano Corpore">Plano Corpore</div>
                </div>



                <div id="coletivo-por-adesao-options-comissions" class="options-comissions-table">
                    <div class="admin" data-detail-plan="Allcare">Allcare</div>
                    <div class="admin" data-detail-plan="Alter">Alter</div>
                    <div class="admin" data-detail-plan="Qualicorp">Qualicorp</div>
                </div>
            </section>

            <section id="content_right_comission">

                <div id="hapvida-table-comission" class="comission-table-tab3 w-75 mx-auto p-2 rounded" style="background-color:#123449;">
                    <h3 class="title-hap text-center">Hapvida</h3>
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>Parcelas</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>2ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>3ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>4ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>5ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>6ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Coletivo por Adesão - Qualicorp -->
                <div id="coletivo-table-comission" class="comission-table-tab3 w-75 mx-auto p-2 rounded" style="background-color:#123449;">
                    <h3 class="title-coletivo text-center">Qualicorp</h3>
                    <table class="table table-sm table-bordered w-75 mx-auto">
                        <thead>
                        <tr>
                            <th>Parcelas</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>2ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>3ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>4ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>5ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>6ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>7ª Parcela</td>
                            <td><input type="text"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>












            </section>


        </div>

    </div>

    <!-- Modal para o formulário -->
    <div class="modal" id="myModal">
        <div class="modal-content">
            <h2>Modal com o formulário</h2>
            <form id="areaAtuacaoForm">
                <!-- Campos do Formulário da Área de Atuação -->
                <!-- Inclua os campos que você deseja no formulário da área de atuação aqui -->
                <label for="areaAtuacao">Área de Atuação</label>
                <input type="text" id="areaAtuacao" name="areaAtuacao">

                <!-- Botão de Salvar (Área de Atuação) -->
                <input type="submit" value="Salvar">
            </form>
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function() {

            function showCities() {
                $("#tab2-content .cities").show();
            }

            // Função para mostrar as opções de comissão
            function showComissionOptions() {
                $("#tab2-content .comission-options").show();
            }

            // Função para mostrar as sub-opções
            function showSubOptions() {
                $("#tab2-content .selected-city .sub-option").show();
            }

            function showEscolherPlano() {
                $("#tab2-content .selected-plano .escolher-plano").show();
            }

            // Área de Atuação
            $("#tab2-content .area-atuacao").click(function() {
                showCities();
            });

            // Cidades
            $("#tab2-content .city").click(function() {
                $(".cities .city").removeClass("destaque");
                $(this).addClass('destaque');

                //var cityName = $(this).text();
                //$("#tab2-content .selected-city").show().find(".city-name").text(cityName);
                showComissionOptions();
            });

            // Opções de Comissão
            $("#tab2-content .option").click(function() {
                $(".comission-options .option").removeClass("destaque");
                $(this).addClass('destaque');
                let optionPlano = $(this).attr('data-texto');
                //console.log(optionPlano);
                //$("#tab2-content .selected-plano").show().find(".escolher-plano").text(optionPlano);
                //$("#tab2-content .selected-plano").show().find(".escolher-plano").text(optionPlano);
                //showEscolherPlano();
                // Esconder todas as opções e mostrar a opção selecionada
                $("#tab2-content .option-group").removeClass("active");
                $("#" + optionPlano.toLowerCase() + "-options").addClass("active");
            });

            $("#tab2-content .sub-option").click(function() {
                $(".option-group .sub-option").removeClass("destaque");
                $(this).addClass('destaque');

                let optionName = $(this).text();

                let tableName = "";
                let tableTitle = "";
                switch(optionName) {
                    case "Plano Individual":
                        tableName = "Hapvida";
                        tableTitle = "Hapvida - Plano Individual";
                        $(".title-hap").text(tableTitle);
                        break;
                    case "Plano Super Simples":
                        tableName = "Hapvida";
                        tableTitle = "Hapvida - Plano Super Simples";
                        $(".title-hap").text(tableTitle);
                        break;
                    case "Plano PME":
                        tableName = "Hapvida";
                        tableTitle = "Hapvida - Plano PME";
                        $(".title-hap").text(tableTitle);
                        break;
                    case "Plano Corpore":
                        tableName = "Hapvida";
                        tableTitle = "Hapvida - Plano Corpore";
                        $(".title-hap").text(tableTitle);
                        break;
                    case "Qualicorp":
                        tableName = "Coletivo";
                        tableTitle = "Qualicorp";
                        $(".title-coletivo").text(tableTitle);
                        break;
                    case "Allcare":
                        tableName = "Coletivo";
                        tableTitle = "Allcare"
                        $(".title-coletivo").text(tableTitle);
                        break;
                    case "Alter":
                        tableName = "Coletivo";
                        tableTitle = "Alter"
                        $(".title-coletivo").text(tableTitle);
                        break;
                    case "Afix":
                        tableName = "Coletivo";
                        tableTitle = "Afix";
                        $(".title-coletivo").text(tableTitle);
                        break;
                }

                $(".comission-table").removeClass("active");
                // Mostrar a tabela correspondente à opção selecionada
                $("#" + tableName.toLowerCase() + "-table").addClass("active");

            });




            $("#imgAlt").on('click',function(){
                $("#logo").click();
            });

            $("#logo").on('change',function(e){
                if(e.target.files.length <= 0) {
                    return;
                }
                let reader = new FileReader();
                reader.onload = () => {
                    $("#imgAlt").attr('src',reader.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });

            // Ao clicar em uma aba, alterne o conteúdo
            $('.tab').on('click', function() {
                var tabId = $(this).data('tab');
                $(".tab").removeClass('active');
                $(this).addClass('active');
                // Esconde todos os conteúdos das abas
                $('.tab-content').removeClass('active').hide();

                // Mostra o conteúdo da aba selecionada
                $('#' + tabId).addClass('active').show();
            });

            // Por padrão, mostra a primeira aba e seu conteúdo
            $('.tab:first').click();

            // Abrir modal ao clicar no botão +
            $('#openModalButton').on('click', function() {
                $('#myModal').css('display', 'block');
            });

            // Fechar modal ao clicar fora do conteúdo do modal
            $(document).on('click', function(event) {
                if (event.target == $('#myModal')[0]) {
                    $('#myModal').css('display', 'none');
                }
            });

            // Enviar formulário da área de atuação e listar na coluna 2
            $('#areaAtuacaoForm').on('submit', function(event) {
                event.preventDefault();
                var areaAtuacao = $('input[name="areaAtuacao"]').val();
                $('#myModal').css('display', 'none');
                $('.column-2').append('<p>' + areaAtuacao + '</p>');
                $('input[name="areaAtuacao"]').val('');
            });


            /**Logica da tab 3***/
            $(".comission-type button").click(function() {
                var type = $(this).text();
                $(".comission-type button").removeClass("active");
                $(this).addClass("active");
                // Esconder todas as opções de comissão
                $(".comission-option").hide();
                // Mostrar as opções correspondentes ao tipo selecionado
                //$("#" + type.toLowerCase().replace(/ /g, '-') + "-options").show();
                $("#comission-cities").show();
            });

            // Exibir a tabela de comissão quando selecionar uma cidade e opção
            $("#comission-cities .city").click(function() {
                let cityName = $(this).text();

                $("#hapvida-options-comissions").css({"display":"flex","flex-direction":"column"});
                //$("#selected-comission-city").show().find(".city-name").text(cityName);
            });

            $("#hapvida-options-comissions .option").click(function(){
                let detail = $(this).attr("data-plan-detail");
                if(detail == "hapvida") {
                    $("#coletivo-por-adesao-options-comissions").css({"display":"none"});
                    $("#hapvida-options-comissions-planos").css({"display":"flex","flex-direction":"column"});
                } else {
                    $("#hapvida-options-comissions-planos").css({"display":"none"});
                    $("#coletivo-por-adesao-options-comissions").css({"display":"flex","flex-direction":"column"});
                }
            });

            // Exibir as opções específicas quando selecionar Hapvida ou Coletivo por Adesão
            $("#comission-options .option").click(function() {
                var optionName = $(this).text();
                $("#selected-comission-option").show().find(".option-name").text(optionName);

                // Esconder todas as tabelas de comissão
                $(".comission-table").removeClass("active");

                // Mostrar a tabela correspondente à opção selecionada
                $("#" + optionName.toLowerCase().replace(/ /g, '-') + "-table").addClass("active");
            });

            $(".options-comissions-table").click(function(){
               let id = $(this).attr("id");
               if(id == "hapvida-options-comissions-planos") {
                   $("#coletivo-table-comission").hide();
                   $("#hapvida-table-comission").show();
               } else {
                   $("#hapvida-table-comission").hide();
                   $("#coletivo-table-comission").show();

               }
            });




        });

    </script>

@stop

@section('css')
<style>

    .dados-corretor {
        display:flex;

    }


    #coletivo-table-comission,
    #hapvida-table-comission
    {
        display:none;
    }



    .tab2-content-left {
        display:flex;
        flex-basis: 45%;
        flex-content:flex-start;
        flex-items:flex-start;

    }

    .tab2-content-right {
        display:flex;
        flex-basis: 55%;
    }

    #area_atuacao::-webkit-scrollbar {
        width: 5px; /* Largura da barra de rolagem */
        height: 3px !important;
        background-color: white; /* Cor de fundo da barra de rolagem */
    }

    /* Estilização do polegar (scrollbar thumb) */
    #area_atuacao::-webkit-scrollbar-thumb {
        background-color: #0dcaf0; /* Cor do polegar (scrollbar thumb) */
    }

    #tab2-content .cities::-webkit-scrollbar {
        width: 5px; /* Largura da barra de rolagem */
        height: 3px !important;
        background-color: white; /* Cor de fundo da barra de rolagem */
    }

    #tab2-content .cities::-webkit-scrollbar-thumb {
        background-color: #0dcaf0; /* Cor do polegar (scrollbar thumb) */
    }


    #tab2-content .area-atuacao {
        display:flex;
        align-content: flex-start !important;
        align-items: flex-start !important;
        justify-content:center;
        height:30px;
        width: 140px;
        color:#FFF;
        background-color: #123449;
        text-align:center;
        cursor: pointer;
    }




    #tab2-content .area-atuacao:hover {
        background-color: #FFF;
        color:#123449;
    }

    #tab2-content .cities {
        display: none;
        margin-left: 10px;
        background-color:#123449;
        color:#FFF;
        border-radius:5px;
        padding:2px;
        height:300px;
        overflow: auto;
    }

    #tab2-content .cities .city {
        cursor: pointer;
        margin-bottom: 5px;
    }

    #tab2-content .option-group {
        display: none;
        background-color:#123449;
        color:#FFF;
        padding:5px;
        margin-left:5px;
        border-radius:5px;
        height:100px;

    }

    #tab2-content .option-group .sub-option {
        cursor:pointer;
    }



    .destaque {
        background-color:white;
        color:black;
    }

    #tab2-content .option-group.active {
        display: block;
    }




    #tab2-content .comission-options {
        display: none;
        background-color:#123449;
        color:#FFF;
        height:70px;
        margin-left:7px;
        border-radius:5px;
        padding:3px;
    }

    #tab2-content .comission-options .option {
        cursor: pointer;
        margin-bottom: 5px;
    }

    #tab2-content .selected-city {
        display: none;
        margin-top: 10px;
    }

    #tab2-content .selected-plano {
        display: none;

    }

    #tab2-content .selected-tipo {
        display: none;

    }


    #tab2-content .escolher-plano {
        display: none;

    }



    #tab2-content .selected-city .option {
        cursor: pointer;
        margin-bottom: 5px;
    }


    /*#tab2-content .option-group .sub-option {*/
    /*    display: none;*/
    /*    margin-left: 20px;*/
    /*    cursor: pointer;*/
    /*}*/



    /* Estilo para as abas */
    .config-block {
        margin-bottom: 20px;
    }

    input[type='file'] {
        display:none;
    }

    .imageContainer {
        max-width: 120px;
        background-color: #eee;
        border:5px solid #ccc;
        border-radius: 5%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin:0 auto;
    }

    .imageContainer img {
        width:100%;
        padding:5px;
        cursor: pointer;
        transition: background .3s;
    }

    .imageContainer:hover {
        background-color: rgb(180,180,180);
        border:5px solid #111;
    }

    .config-line {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .config-line label {
        flex-basis: 50%;
        box-sizing: border-box;
        padding: 5px;
    }

    .config-line input {
        flex: 1;
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid #ccc;
    }

    .column {
        display: flex;
        flex-direction: column;
        flex-basis: 50%;


    }

    .columns {
        display: flex;
        flex-direction: column;
        flex-basis: 50%;
        padding: 10px;
    }

    .columns-1 {
        display:flex;
        flex-basis:40%;
        flex-wrap: wrap;
        justify-content: space-between;
        align-content: flex-start;
        align-items: flex-start;
    }

    .columns-2 {
        display:flex;
        flex-basis:60%;
        flex-wrap: wrap;
        align-content: flex-start;
        align-items: flex-start;
        justify-content: space-between;
    }

    .tab-container {
        display: flex;
    }

    .tab {
        display: inline-block;
        cursor: pointer;
        padding: 10px;
        background-color: #123449;
        color: #fff;
        border-radius: 5px 5px 0 0;
    }

    .active.tab {
        background-color: #FFF;
        color:#123449;
        font-weight:bold;
    }

    .tab-content {
        display: none;
        margin-top:5px;
        width: 100%;
    }

    /* Estilo para o layout da primeira aba */
    .column-wrapper {
        display: flex;
        width: 100%;
    }

    .column-1 {
        flex-basis: 10%;
    }

    .column-2 {
        flex-basis: 38%;
        background-color:#123449;
        border-radius: 5px;
        margin:0 1%;
    }

    .column-2 span  {
        color:#FFF;
        font-weight:normal;
    }

    .column-3 {
        flex-basis: 50%;
    }

    /* Estilo para a modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }


    .comission-table {
        display: none;
        width: 100%;
        margin-left: 30px;
        background-color:#123449;
        color:#FFF;
        padding:5px;
        border-radius:5px;
    }

    .comission-table.active {
        display: block;
    }


    #tab3-content {
        display:flex;
    }

    #tab3-content #content_left_comission {
        display:flex;
        flex-basis:38%;
    }

    #tab3-content #content_right_comission {
        display:flex;
        flex-basis:62%;

        color:#FFF;
    }

    /*#tab3-content .comission-option {*/
    /*    display: none;*/
    /*    background-color:#123449;*/
    /*    color:#FFF;*/
    /*    height:70px;*/
    /*    margin-left:7px;*/
    /*    border-radius:5px;*/
    /*    padding:3px;*/
    /*}*/

    #tab2-content .comission-options .option {
        cursor: pointer;
        margin-bottom: 5px;
    }

    #hapvida-options-comissions-planos {
        display: none;
        background-color:#123449;
        color:#FFF;
        padding:5px;
        margin-left:5px;
        border-radius:5px;
        height:100px;
        width:180px;
        min-width:180px;
    }




    #coletivo-por-adesao-options-comissions {
        display: none;
        background-color:#123449;
        color:#FFF;
        padding:5px;
        margin-left:5px;
        border-radius:5px;
        height:100px;
        width:80px;
        min-width:80px;
    }


    #comission-cities {
        display:none;
        margin-left: 10px;
        background-color:#123449;
        color:#FFF;
        border-radius:5px;
        padding:2px;
        height:300px;
        overflow: auto;
        flex-basis:100px;
        min-width:100px;
        width:100px !important;

    }

    #hapvida-options-comissions {
        display: none;
        background-color:#123449;
        color:#FFF;
        height:70px;
        margin-left:7px;
        border-radius:5px;
        min-width:160px !important;
        padding:3px;
        width:160px !important;
    }


    .comission-type {
        display:flex;
        flex-direction: column;
        width:138px;

    }

    #hapvida-options-comissions-planos.comission-option,
    #coletivo-por-adesao-options-comissions.comission-option {
        margin-left:20px;
    }




</style>
    @stop

