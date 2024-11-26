<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'conexao_banco.php';

if (isset($_GET['id'])) {
    $idItem = $_GET['id'];

    $query = "SELECT * FROM tb_itens WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $idItem);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $item = $resultado->fetch_assoc();
    } else {
        header('Location: cardapio.php');
        exit();
    }
} else {
    header('Location: cardapio.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Item</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
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
                    <li><a href="includes/autenticar.php?acao=sair">Sair</a></li>
                <?php else: ?>
                    <li><a href="login.php">Entrar</a></li>
                    <li><a href="cadastro.php">Cadastrar-se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="item-details">
            <?php if ($item): ?>
                <img src="<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                <h2><?php echo htmlspecialchars($item['nome']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($item['descricao'])); ?></p>
                <p class="price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>

                <form action="processar_pedido.php" method="POST">
                    <input type="hidden" name="idItem" value="<?php echo $item['id']; ?>">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" name="quantidade" id="quantidade" value="1" min="1" required>
                    <button type="submit" class="btn">Adicionar ao Pedido</button>
                </form>
            <?php else: ?>
                <p>Item não encontrado.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
