<?php
// Recebe os parâmetros da URL
$nome = isset($_GET['nome']) ? urldecode($_GET['nome']) : 'NOME NÃO INFORMADO';
$imposto = isset($_GET['imposto']) ? str_replace(',', '.', $_GET['imposto']) : '48,75';
$data = isset($_GET['data']) ? $_GET['data'] : '06/08/2025';

// Formata a data para o padrão brasileiro
if (strlen($data) == 8) {
    $data_formatada = substr($data, 0, 2) . '/' . substr($data, 2, 2) . '/' . substr($data, 4, 4);
} else {
    $data_formatada = $data;
}

// Formata o valor do imposto
$imposto_formatado = 'R$ ' . number_format(floatval($imposto), 2, ',', '.');

// Carrega a imagem original
$imagem_original = '/var/www/html/image.png';
$imagem = imagecreatefrompng($imagem_original);

if (!$imagem) {
    die('Erro ao carregar a imagem');
}

// Define a cor do texto (preto)
$cor_texto = imagecolorallocate($imagem, 0, 0, 0);

// Define a fonte (usando fonte padrão do sistema)
$fonte_size = 12;

// Substitui o nome
imagestring($imagem, 5, 43, 178, $nome, $cor_texto);

// Substitui a data de emissão
imagestring($imagem, 3, 246, 245, $data_formatada, $cor_texto);

// Substitui a data de vencimento  
imagestring($imagem, 3, 372, 245, $data_formatada, $cor_texto);

// Substitui o valor do imposto obrigatório (campo principal)
imagestring($imagem, 4, 371, 317, $imposto_formatado, $cor_texto);

// Substitui o valor do imposto obrigatório (campo inferior)
imagestring($imagem, 4, 31, 743, $imposto_formatado . ' até ' . $data_formatada, $cor_texto);

// Define o cabeçalho para exibir a imagem
header('Content-Type: image/png');

// Exibe a imagem
imagepng($imagem);

// Libera a memória
imagedestroy($imagem);
?>
