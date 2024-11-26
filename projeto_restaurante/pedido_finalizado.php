<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensagem = isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : "Pedido finalizado com sucesso!";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Finalizado</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        .mensagem-container {
            margin: 100px auto;
            padding: 20px;
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .mensagem-container h1 {
            font-size: 24px;
            color: #1E2A38;
        }

        .mensagem-container p {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }

        .botao-voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FFD700;
            color: #1E2A38;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .botao-voltar:hover {
            background-color: #ffcc00;
        }
    </style>
</head>
<body>
    <div class="mensagem-container">
        <h1>Obrigado!</h1>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
        <a href="index.php" class="botao-voltar">Voltar para a Página Inicial</a>
    </div>
</body>
</html>
