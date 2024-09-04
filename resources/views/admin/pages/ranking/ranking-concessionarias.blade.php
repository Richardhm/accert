@foreach($ranking as $i => $r)
    @if ($i % 6 === 0)
        <div class="slide" style="height:100%;">
            @endif
            <section style="display:flex;width:99%;justify-content:center;margin:10px auto;background-color:#2e4a7a;border-radius:10px;">
                <!-- 1º Div: Posição ocupa toda a altura da section -->
                <div style="background-color:#5d859e;font-weight:bold;color:#FFF;padding:5px 35px;font-size:1.2em;display: flex;align-items: center;justify-content: center;border-radius:5px;">
                    {{$loop->iteration}}°
                </div>

                <!-- 2º Div: Imagem centralizada no eixo Y com border-radius, próxima da 1ª div -->


                <!-- 3º Div: Próxima da 2ª div -->
                <div style="display:flex;flex-direction: column;margin-left: 8px;color:#FFF;font-size:0.875em;min-width:50%">
                    <p style="margin:0;padding:0;">{{$r->nome}}</p>
                    <div style="display:flex;margin:0;padding:0;justify-content:space-between;">
                        <p style="margin:0;padding:0;">Meta: 200 Vidas</p>
                        <p style="margin:0;padding:0;">Total: {{$r->total_vidas}} Vidas</p>
                    </div>
                    <div>
                        <div class="progress">

                            <div class="progress-bar bg-yellow progress-bar-striped" role="progressbar" aria-valuenow="{{$r->porcentagem_vendas}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$r->porcentagem_vendas}}%">
                                <span class="sr-only" style="color:red;font-weight:bold;">{{$r->porcentagem_vendas}}%</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Faltam: {{200 - $r->total_vidas}} Vidas</p>
                    </div>
                </div>

                <!-- 4º Div: Encostado do lado direito -->
                <div style="flex: 3;text-align: right;padding:2px;color:#FFF;font-size:0.875em;">
                    <p style="margin:0;padding:0;">Individual: 0 vidas</p>
                    <p style="margin:0;padding:0;">Coletivo: 0 vidas</p>
                    <p style="margin:0;padding:0;">Empresarial: 0 vidas</p>
                    <p style="margin:0;padding:0;">Total: 0 vidas</p>
                </div>
            </section>
            @if (($i + 1) % 6 === 0)
        </div>
    @endif
@endforeach
