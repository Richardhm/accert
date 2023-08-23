<ul style="list-style:none;margin:0;padding:0;" class="w-100">
    @php
        $iix = 0;
    @endphp

    @foreach($users as $uu)
        @php
            $iix++;
            $texto = $uu->user;
            $palavras = \Illuminate\Support\Str::words($texto, 2, '');
            $primeiroNome = explode(' ', $palavras)[0]; // Obtém o primeiro nome
            $sobrenome = explode(' ', $palavras)[1];
            $iniciaisSobrenome = substr($sobrenome,0,5);
            $nomeAbreviado = $primeiroNome . ' ' . $iniciaisSobrenome . '.';
            //$textoLimitado = \Illuminate\Support\Str::before($palavras, ' ') . (\Illuminate\Support\Str::contains($texto, ' ') ? '...' : '');
        @endphp

        <li class="d-flex justify-content-between text-white w-100 py-1 {{$iix % 2 == 0 ? 'user_destaque_impar' : ''}}">
            <span style="font-size:0.7em;display:flex;flex-basis:71%;" class="user_destaque" data-id="{{$uu->user_id}}">{{$texto}}</span>
            <span style="font-size:0.6em;display:flex;flex-basis:29%;justify-content:right;margin-right:2%;" class="total_pagamento_finalizado user_destaque" data-id="{{$uu->user_id}}">{{number_format($uu->total,2,",",".")}}</span>

        </li>
    @endforeach
</ul>
