<?php

// Inicializa a sessão cURL
$ch = curl_init();

// Define a URL alvo
$url = 'https://www.questmultimarcas.com.br/estoque';

// Define as opções da requisição cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição e obtém o conteúdo da página
$response = curl_exec($ch);

// Verifica se houve erros durante a requisição
if (curl_errno($ch)) {
    echo 'Erro ao acessar a URL: ' . curl_error($ch);
    // Você pode adicionar tratamento de erro aqui, se necessário
}

// Encerra a sessão cURL
curl_close($ch);

// Agora, você pode analisar o conteúdo da variável $response para extrair os dados que deseja
// Lembre-se que a extração de dados específicos do HTML pode variar dependendo da estrutura do site

// Exemplo de como encontrar um título da página dentro do HTML retornado
//$pattern = '/<title>(.*?)<\/title>/';

$pattern = '/<div class="col mt-2 p-0">\s*<h3>(.*?)<\/h3>\s*<\/div>/s';

preg_match($pattern, $response, $matches);

echo "<pre>";
print_r($matches);
echo "</pre>";


/*
if (isset($matches[1])) {
    echo 'Título da página: ' . $matches[1];
} else {
    echo 'Título não encontrado';
}*/
?>
