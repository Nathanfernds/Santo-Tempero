<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'conexao_banco.php';

$id_usuario = $_SESSION['usuario']['id'];

$query_pedido = "SELECT ip.id, ip.idItem, ip.quantidade, ip.preco, i.nome
                 FROM tb_itens_pedido ip
                 JOIN tb_itens i ON ip.idItem = i.id
                 WHERE ip.idUsuario = ? AND ip.finalizado = 0";
$stmt_pedido = $conexao->prepare($query_pedido);
$stmt_pedido->bind_param("i", $id_usuario);
$stmt_pedido->execute();
$resultado_pedido = $stmt_pedido->get_result();

if (isset($_GET['remover'])) {
    $id_item_remover = $_GET['remover'];
    $query_remover = "DELETE FROM tb_itens_pedido WHERE id = $id_item_remover AND idUsuario = $id_usuario";
    mysqli_query($conexao, $query_remover);
    header('Location: pedido.php');
    exit();
}

if (isset($_POST['alterar_quantidade'])) {
    $id_item = $_POST['id_item'];
    $nova_quantidade = $_POST['nova_quantidade'];

    if ($nova_quantidade > 0) {
        $query_atualizar = "UPDATE tb_itens_pedido
                            SET quantidade = $nova_quantidade
                            WHERE id = $id_item AND idUsuario = $id_usuario";
        mysqli_query($conexao, $query_atualizar);
    }
    header('Location: pedido.php');
    exit();
}

if (isset($_POST['confirmar_pedido'])) {
    $query_confirmar = "UPDATE tb_itens_pedido SET finalizado = 1 WHERE idUsuario = $id_usuario AND finalizado = 0";
    mysqli_query($conexao, $query_confirmar);
    header('Location: pedido_finalizado.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - Santo Tempero</title>
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
        position: relative;
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

    .pedido-container {
        padding: 40px 20px;
        text-align: center;
    }

    .pedido-container h2 {
        font-size: 28px;
        color: #1E2A38;
        margin-bottom: 20px;
    }

    .pedido-tabela {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .pedido-tabela th,
    .pedido-tabela td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
    }

    .pedido-tabela th {
        background-color: #FFD700;
        color: #1E2A38;
        font-weight: bold;
    }

    .pedido-tabela td input[type="number"] {
        width: 60px;
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .alterar-btn,
    .remover-btn,
    .confirmar-btn {
        display: inline-block;
        padding: 10px 15px;
        margin-top: 10px;
        color: #1E2A38;
        background-color: #FFD700;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 16px;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .alterar-btn:hover,
    .remover-btn:hover,
    .confirmar-btn:hover {
        background-color: #ffcc00;
    }

    .total {
        margin-top: 20px;
        font-size: 18px;
        text-align: center;
        color: #333;
    }

    .total p {
        font-weight: bold;
        color: #FFD700;
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
    <a href="cardapio.php" class="retornar-btn">Retornar ao Cardápio</a>
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


    <main class="pedido-container">
        <h2>Seu Pedido</h2>

        <?php if (mysqli_num_rows($resultado_pedido) > 0): ?>
            <table class="pedido-tabela">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Preço Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($resultado_pedido)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td>
                                <form action="pedido.php" method="POST">
                                    <input type="number" name="nova_quantidade" value="<?php echo $item['quantidade']; ?>" min="1">
                                    <input type="hidden" name="id_item" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="alterar_quantidade" class="alterar-btn">Alterar</button>
                                </form>
                            </td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></td>
                            <td><a href="pedido.php?remover=<?php echo $item['id']; ?>" class="remover-btn">Remover</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="total">
                <h3>Total do Pedido:</h3>
                <p>R$ 
                    <?php 
                    $query_total = "SELECT SUM(ip.quantidade * ip.preco) AS total
                                    FROM tb_itens_pedido ip
                                    WHERE ip.idUsuario = $id_usuario AND ip.finalizado = 0";
                    $resultado_total = mysqli_query($conexao, $query_total);
                    $total = mysqli_fetch_assoc($resultado_total)['total'];
                    echo number_format($total, 2, ',', '.');
                    ?>
                </p>
            </div>

            <form action="pedido.php" method="POST">
                <button type="submit" name="confirmar_pedido" class="confirmar-btn">Confirmar Pedido</button>
            </form>

        <?php else: ?>
            <p>Seu pedido está vazio. Adicione itens ao seu pedido!</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
