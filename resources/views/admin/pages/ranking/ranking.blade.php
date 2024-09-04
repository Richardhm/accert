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
                <div style="flex: 0 1 auto; display: flex; align-items: center; margin-left: 8px;">
                    <img src="{{ asset('storage/'.$r->imagem) }}" class="rounded" style="height:60px;width:60px;border-radius:50%;" />
                </div>

                <!-- 3º Div: Próxima da 2ª div -->
                <div style="display:flex;flex-direction: column;margin-left: 8px;color:#FFF;font-size:0.875em;min-width:50%">
                    <p style="margin:0;padding:0;">{{$r->corretor}}</p>
                    <div style="display:flex;margin:0;padding:0;justify-content:space-between;">
                        <p style="margin:0;padding:0;">Meta: 200 Vidas</p>
                        <p style="margin:0;padding:0;">Total: {{$r->quantidade_vidas}} Vidas</p>
                    </div>
                    <div>
                        <div class="progress">
                            @php
                                $porcentagem = ($r->quantidade_vidas / 200) * 100;
                            @endphp
                            <div class="progress-bar bg-yellow progress-bar-striped" role="progressbar" aria-valuenow="{{$porcentagem}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentagem}}%">
                                <span class="sr-only" style="color:red;font-weight:bold;">{{$porcentagem}}%</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Faltam: {{200 - $r->quantidade_vidas}} Vidas</p>
                    </div>
                </div>

                <!-- 4º Div: Encostado do lado direito -->
                <div style="flex: 3;text-align: right;padding:2px;color:#FFF;font-size:0.875em;">
                    <p style="margin:0;padding:0;">Individual: {{$r->quantidade_individual}} vidas</p>
                    <p style="margin:0;padding:0;">Coletivo: {{$r->quantidade_coletivo}} vidas</p>
                    <p style="margin:0;padding:0;">Empresarial: {{$r->quantidade_empresarial}} vidas</p>
                    <p style="margin:0;padding:0;">Total: {{$r->quantidade_vidas}} vidas</p>
                </div>
            </section>
            @if (($i + 1) % 6 === 0)
        </div>
    @endif
@endforeach
