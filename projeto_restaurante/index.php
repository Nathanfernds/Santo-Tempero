<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'conexao_banco.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Santo Tempero</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #1E2A38;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        nav ul {
            list-style-type: none;
            margin-top: 10px;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #FFD700;
        }

        main {
            padding: 40px 20px;
            text-align: center;
        }

        .welcome-section {
            background-color: #fff;
            padding: 40px;
            margin: 20px auto;
            border-radius: 8px;
            width: 80%;
            max-width: 700px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h2 {
            font-size: 28px;
            color: #1E2A38;
            margin-bottom: 15px;
        }

        .welcome-section p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .welcome-section .btn {
            background-color: #FFD700;
            color: #1E2A38;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .welcome-section .btn:hover {
            background-color: #ffcc00;
        }

        footer {
            background-color: #1E2A38;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
        }

        footer p {
            font-size: 14px;
        } 

        .images-section {
            text-align: center;
            margin-top: 40px;
        }

        .images-section h3 {
            font-size: 1.6em;
            color: #333;
            margin-bottom: 20px;
        }

        .image-gallery {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .image-item {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .image-item:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <h1>Santo Tempero</h1>
        <nav>
            <ul>
                <li><a href="index.php">Página Inicial</a></li>
                <li><a href="cardapio.php">Cardápio</a></li>
                <li><a href="pedido.php">Meu Pedido</a></li>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="login.php">Entrar</a></li>
                    <li><a href="cadastro.php">Cadastrar-se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

<main>
    <section class="welcome-section">
        <h2>Explore nosso cardápio!</h2>
        <p>Descubra uma variedade de pratos deliciosos para todos os gostos.</p>
        <a href="cardapio.php" class="btn">Ver Cardápio</a>
    </section>

    <section class="images-section">
        <h3>Deliciosos Pratos</h3>
        <div class="image-gallery">
            <img src="img/feijoada.jpg" alt="Prato 1" class="image-item">
            <img src="img/parmegiana.jpeg" alt="Prato 2" class="image-item">
            <img src="img/Bife.jpg" alt="Prato 3" class="image-item">
        </div>
    </section>
</main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

