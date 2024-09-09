<?php
session_start(); // Inicia a sessão

include_once 'conexao.php';

// Verifica se a conexão foi estabelecida
if (!$conex) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Recebe o CEP enviado pelo formulário
$cep = $_POST['cep'];
$url = "https://viacep.com.br/ws/$cep/json/";
$response = file_get_contents($url);
$dados_cep = json_decode($response, true);

// Verifica se o CEP é válido
if (!isset($dados_cep['cep']) || $dados_cep['cep'] === '') {
    $_SESSION['mensagem'] = "CEP inválido";
    $_SESSION['tipo_mensagem'] = "danger"; // Tipo de mensagem para a classe de alerta
    header('Location: index.php');
    exit();
}

// Armazena os dados do CEP na sessão
$_SESSION['cep_dados'] = [
    'logradouro' => $dados_cep['logradouro'],
    'bairro' => $dados_cep['bairro'],
    'cidade' => $dados_cep['localidade'],
    'uf' => $dados_cep['uf'],
    'cep' => $dados_cep['cep']
];

// Mensagem de sucesso
$_SESSION['mensagem'] = "Dados do CEP recebidos com sucesso";
$_SESSION['tipo_mensagem'] = "success"; // Tipo de mensagem para a classe de alerta

// Redireciona para a página index.php
header('Location: index.php');
exit();
?>
