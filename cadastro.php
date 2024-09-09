<?php 
    include_once 'conexao.php';
    //COMANDO ACIMA FAZ: 
    // - inclui o arquivo conexao.php
    // - conecta ao banco de dados
    session_start(); // Inicia a sessão

    $nome = $_POST['nome'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];

    $inserir_cliente = "INSERT INTO clientes (cli_nome, cli_logradouro, cli_numero, cli_complemento, cli_bairro, cli_cidade, cli_uf, cli_cep) VALUES ('$nome', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$uf', '$cep')";

    $query_cadastros = mysqli_query($conex, $inserir_cliente);
    if (!$query_cadastros) {
        die('Erro ao inserir cliente: ' . mysqli_error($conex));
    }

    if ($query_cadastros) {
        // Pega o nome do cliente excluído para a mensagem
        $nome_cliente = $nome;
        $_SESSION['mensagem'] = "O cadastro de $nome_cliente foi cadastrado com sucesso.";
        $_SESSION['tipo_mensagem'] = "success"; // Tipo de alerta (success, danger, etc.)
    } else {
        $_SESSION['mensagem'] = "Houve um problema ao adicionar o cadastro.";
        $_SESSION['tipo_mensagem'] = "danger"; // Tipo de alerta (success, danger, etc.)
    }

    header('location:index.php');
?>
