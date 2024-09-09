<?php 
session_start(); // Inicia a sessão

include_once 'conexao.php';

// Pegando o método POST do formulário de exclusão no arquivo index.php
$id = $_POST['id'];

// Executa a exclusão do cliente
$excluir_cliente = "DELETE FROM clientes WHERE cli_id = $id";
$query_excluir = mysqli_query($conex, $excluir_cliente);

if ($query_excluir) {
    // Pega o nome do cliente excluído para a mensagem
    $nome_cliente = $_POST['nome'];
    $_SESSION['mensagem'] = "O cadastro de $nome_cliente foi excluído com sucesso.";
    $_SESSION['tipo_mensagem'] = "success"; // Tipo de alerta (success, danger, etc.)
} else {
    $_SESSION['mensagem'] = "Houve um problema ao excluir o cadastro.";
    $_SESSION['tipo_mensagem'] = "danger"; // Tipo de alerta (success, danger, etc.)
}

header('Location: index.php'); // Redireciona para a página index.php após exclusão
?>
