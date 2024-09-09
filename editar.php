<?php 
    session_start(); // Inicia a sessão

    include_once 'conexao.php';
    
    // Recebe e sanitiza os dados do formulário
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
    $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
    $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
    $uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

    // Depuração: Verifica valores recebidos
    if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
        $_SESSION['mensagem'] = "ID inválido ou não fornecido.";
        $_SESSION['tipo_mensagem'] = "danger";
        header('Location: index.php');
        exit();
    }

    // Comando SQL para atualizar os dados dos clientes
    $atualizar_clientes = "UPDATE clientes SET cli_nome=?, cli_logradouro=?, cli_numero=?, cli_complemento=?, cli_bairro=?, cli_cidade=?, cli_uf=?, cli_cep=? WHERE cli_id=?";
    $stmt = mysqli_prepare($conex, $atualizar_clientes);

    // Verifica se a preparação foi bem-sucedida
    if ($stmt === false) {
        $_SESSION['mensagem'] = "Erro ao preparar a consulta SQL.";
        $_SESSION['tipo_mensagem'] = "danger";
        header('Location: index.php');
        exit();
    }

    // Liga as variáveis aos parâmetros da query
    mysqli_stmt_bind_param($stmt, 'ssissssss', $nome, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $cep, $id);

    // Executa a query
    $query_editar = mysqli_stmt_execute($stmt);

    // Verifica se a execução foi bem-sucedida
    if ($query_editar) {
        $_SESSION['mensagem'] = "O cadastro de $nome foi editado com sucesso.";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Houve um problema ao editar o cadastro: " . mysqli_stmt_error($stmt);
        $_SESSION['tipo_mensagem'] = "danger";
    }

    // Fecha a statement e a conexão
    mysqli_stmt_close($stmt);
    mysqli_close($conex);

    header('Location: index.php');
    exit();
?>
