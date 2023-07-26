    <ul style="list-style: none;margin:0;padding:0;" class="w-100">
        @foreach($users as $u)
            @php
                $texto = $u->user;
                $palavras = \Illuminate\Support\Str::words($texto, 2, '');
                $primeiroNome = explode(' ', $palavras)[0]; // Obtém o primeiro nome
                $sobrenome = explode(' ', $palavras)[1];
                $iniciaisSobrenome = $sobrenome[0];
                $nomeAbreviado = $primeiroNome . ' ' . $iniciaisSobrenome . '.';
            @endphp

            <li class="d-flex justify-content-between border-top border-bottom border-white text-white w-100 py-2">
                <span style="font-size:0.8em;flex-basis:50%;" class="user_destaque" data-id="{{$u->user_id}}">{{$nomeAbreviado}}</span>
                <span style="font-size:0.8em;flex-basis:40%;text-align:right;margin-right:2%;" class="total_pagamento_finalizado user_destaque" data-id="{{$u->user_id}}">{{number_format($u->total,2,",",".")}}</span>
                <span style="font-size:0.8em;flex-basis:10%;"><i class="fas fa-file-pdf criar_pdf" data-id="{{$u->user_id}}"></i></span>
            </li>
        @endforeach
    </ul>

