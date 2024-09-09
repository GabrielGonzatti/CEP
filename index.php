<?php
session_start(); // Inicia a sessão

include_once 'conexao.php';

// Verifica se há uma mensagem para ser exibida
if (isset($_SESSION['mensagem'])): ?>
    <div class="alert alert-<?php echo htmlspecialchars($_SESSION['tipo_mensagem']); ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['mensagem']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php 
    // Remove a mensagem após exibir
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
endif;

// Verifica se há dados do CEP na sessão
$cep_dados = isset($_SESSION['cep_dados']) ? $_SESSION['cep_dados'] : null;
unset($_SESSION['cep_dados']); // Limpa os dados após exibir
?>

<!doctype html>
<html lang="pt-br">
<head>
    <title>Trata CEP</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <!-- Formulário de busca e listagem de clientes -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Logradouro</th>
                    <th>Número</th>
                    <th>Complemento</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>CEP</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Busca todos os clientes
                $buscar_clientes = "SELECT * FROM clientes";
                $query_clientes = mysqli_query($conex, $buscar_clientes);
                
                while($receber_clientes = mysqli_fetch_array($query_clientes)){
                    $id = htmlspecialchars($receber_clientes['cli_id']);
                    $nome = htmlspecialchars($receber_clientes['cli_nome']);
                    $logradouro = htmlspecialchars($receber_clientes['cli_logradouro']);
                    $numero = htmlspecialchars($receber_clientes['cli_numero']);
                    $complemento = htmlspecialchars($receber_clientes['cli_complemento']);
                    $bairro = htmlspecialchars($receber_clientes['cli_bairro']);
                    $cidade = htmlspecialchars($receber_clientes['cli_cidade']);
                    $uf = htmlspecialchars($receber_clientes['cli_uf']);
                    $cep = htmlspecialchars($receber_clientes['cli_cep']);
                ?>
                <tr>
                    <!-- FORM EDITAR -->
                    <form action="editar.php" method="post">
                        <td><?php echo $id ?></td>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <td><input type="text" name="nome" value="<?php echo $nome ?>" size="120"></td>
                        <td><input type="text" name="logradouro" value="<?php echo $logradouro ?>" size="120"></td>
                        <td><input type="text" name="numero" value="<?php echo $numero ?>" size="5"></td>
                        <td><input type="text" name="complemento" value="<?php echo $complemento ?>" size="5"></td>
                        <td><input type="text" name="bairro" value="<?php echo $bairro ?>" size="120"></td>
                        <td><input type="text" name="cidade" value="<?php echo $cidade ?>" size="120"></td>
                        <td><input type="text" name="uf" value="<?php echo $uf ?>" size="120"></td>
                        <td><input type="text" name="cep" value="<?php echo $cep ?>" size="120"></td>
                        <td><input type="submit" value="Editar"></td>
                    </form>
                    <td>
                        <form action="excluir.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="hidden" name="nome" value="<?php echo $nome ?>">
                            <input type="submit" value="Excluir">
                        </form>
                    </td>
                </tr>
                <?php } ?> 

                <tr>
                    <!-- FORMULÁRIO DE CADASTRO -->
                    <form action="cadastro.php" method="post">
                        <td></td>
                        <td><input type="text" name="nome" size="80" placeholder="Seu nome"></td>
                        <td><input type="text" name="logradouro" value="<?php echo isset($cep_dados['logradouro']) ? htmlspecialchars($cep_dados['logradouro']) : ''; ?>" size="80"></td>
                        <td><input type="text" name="numero" size="20" placeholder="Informe Nº da casa"></td>
                        <td><input type="text" name="complemento" size="10" placeholder="NºAp. Casa1/2"></td>
                        <td><input type="text" name="bairro" size="30" value="<?php echo isset($cep_dados['bairro']) ? htmlspecialchars($cep_dados['bairro']) : ''; ?>"></td>
                        <td><input type="text" name="cidade" size="20" value="<?php echo isset($cep_dados['cidade']) ? htmlspecialchars($cep_dados['cidade']) : ''; ?>"></td>
                        <td><input type="text" name="uf" size="3" value="<?php echo isset($cep_dados['uf']) ? htmlspecialchars($cep_dados['uf']) : ''; ?>"></td>
                        <td><input type="text" name="cep" size="10" value="<?php echo isset($cep_dados['cep']) ? htmlspecialchars($cep_dados['cep']) : ''; ?>"></td>
                        <td><input type="submit" value="Gravar"></td>
                    </form>
                </tr>

                <tr>
                    <!-- FORMULÁRIO DE BUSCA DE CEP -->
                    <form action="correios.php" method="post">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" name="cep" size="10"></td>
                        <td><input type="submit" value="Busca CEP"></td>
                    </form>
                </tr>
            </tbody>
        </table>

        <!-- Exibe os dados do CEP se disponíveis -->
        <?php if ($cep_dados): ?>
            <div class="mt-4">
                <h5>Dados do CEP:</h5>
                <p><strong>Logradouro:</strong> <?php echo htmlspecialchars($cep_dados['logradouro']); ?></p>
                <p><strong>Bairro:</strong> <?php echo htmlspecialchars($cep_dados['bairro']); ?></p>
                <p><strong>Cidade:</strong> <?php echo htmlspecialchars($cep_dados['cidade']); ?></p>
                <p><strong>UF:</strong> <?php echo htmlspecialchars($cep_dados['uf']); ?></p>
                <p><strong>CEP:</strong> <?php echo htmlspecialchars($cep_dados['cep']); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
