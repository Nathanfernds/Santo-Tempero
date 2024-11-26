<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'conexao_banco.php';

$query_categoria = "SELECT * FROM tb_categoria";
$resultado_categoria = mysqli_query($conexao, $query_categoria);

$query_item = "SELECT * FROM tb_itens";
$resultado_item = mysqli_query($conexao, $query_item);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Santo Tempero</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
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

        .cardapio-container {
            padding: 40px 20px;
            text-align: center;
        }

        h2 {
            font-size: 28px;
            color: #1E2A38;
            margin-bottom: 20px;
        }

        .categorias {
            display: block;
            margin: 0 auto;
        }

        .categoria {
            width: 400px; 
            margin-left: 455px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #FFD700;
        }

        .categoria h3 {
            color: #1E2A38;
            margin-bottom: 10px;
        }

        .categoria img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .item {
            text-align: left;
        }

        .item img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .item h4 {
            font-size: 1.1em;
            color: #FFD700;
            margin: 5px 0;
        }

        .item p {
            color: #666;
            font-size: 0.9em;
        }

        .detalhes-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #FFD700;
            color: #1E2A38;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .detalhes-btn:hover {
            background-color: #ffcc00;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #1E2A38;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
            font-size: 14px;
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

    <main class="cardapio-container">
        <h2>Nosso Cardápio</h2>

        <?php if (mysqli_num_rows($resultado_categoria) > 0): ?>
            <div class="categorias">
                <?php while ($categoria = mysqli_fetch_assoc($resultado_categoria)): ?>
                    <div class="categoria">
                        <?php 
                            $categoria_id = $categoria['id'];
                            switch ($categoria_id) {
                                case 1:
                                    $link_categoria = "entradas.php?id=$categoria_id"; 
                                    break;
                                case 2:
                                    $link_categoria = "pratos_principais.php?id=$categoria_id";  
                                    break;
                                case 3:
                                    $link_categoria = "bebidas.php?id=$categoria_id";  
                                    break;
                                default:
                                    $link_categoria = "sobremesas.php?id=$categoria_id";  
                            }
                        ?>

                        <a href="<?php echo $link_categoria; ?>">
                        <h3><?php echo htmlspecialchars($categoria['nome']); ?></h3>
                        </a>
    
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Não há categorias cadastradas no cardápio.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>



