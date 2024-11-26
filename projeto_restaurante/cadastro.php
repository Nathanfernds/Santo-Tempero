<?php

session_start();

include 'conexao_banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $rua = mysqli_real_escape_string($conexao, $_POST['rua']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $confirmar_senha = mysqli_real_escape_string($conexao, $_POST['confirmar_senha']);

    if ($senha === $confirmar_senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $query = "INSERT INTO tb_usuario (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado)
                  VALUES ('$nome', '$email', '$data_nascimento', '$telefone', '$senha_hash', '$cep', '$rua', '$numero', '$bairro', '$complemento', '$cidade', '$estado')";
        
        if (mysqli_query($conexao, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $erro = "Erro ao cadastrar usuário. Tente novamente.";
        }
    } else {
        $erro = "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Restaurante</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img/Bife.jpg');
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center; 
            color: #333;
        }

        .cadastro-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cadastro-container h2 {
            font-size: 26px;
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .cadastro-container form {
            display: flex;
            flex-direction: column;
        }

        .cadastro-container label {
            font-size: 15px;
            margin-bottom: 5px;
            color: #555;
        }

        .cadastro-container input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .cadastro-container input:focus {
            border-color: #3498db;
            outline: none;
        }

        .cadastro-container button {
            padding: 12px;
            background-color: #FFD700;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cadastro-container button:hover {
            background-color: #ffcc00;
        }

        .cadastro-container .erro {
            color: #e74c3c;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        .cadastro-container p {
            text-align: center;
            font-size: 14px;
            color: #333;
        }

        .cadastro-container p a {
            color: #3498db;
            text-decoration: none;
        }

        .cadastro-container p a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const erroContainer = document.createElement('div');
            erroContainer.style.color = 'red';
            form.prepend(erroContainer);

            form.addEventListener('submit', function(event) {
                const erros = [];
                const nome = form.querySelector('#nome').value.trim();
                const email = form.querySelector('#email').value.trim();
                const senha = form.querySelector('#senha').value;
                const confirmarSenha = form.querySelector('#confirmar_senha').value;

                if (!nome) erros.push('O nome é obrigatório.');
                if (senha !== confirmarSenha) erros.push('As senhas não coincidem.');

                if (erros.length > 0) {
                    event.preventDefault();
                    erroContainer.innerHTML = erros.join('<br>');
                }
            });
        });
    </script>
</head>
<body>
    <main class="cadastro-container">
        <h2>Cadastrar-se</h2>

        <?php if (isset($erro)): ?>
            <p class="erro"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required>

            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" required>

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" required>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" required>

            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento">

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required>

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" maxlength="2" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>

            <button type="submit">Cadastrar</button>
        </form>

        <p>Já tem uma conta? <a href="login.php">Entrar aqui</a>.</p>
    </main>
</body>
</html>
