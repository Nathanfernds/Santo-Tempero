<?php

session_start();

include 'conexao_banco.php';

$categoria_bebida_id = 3;

$query_bebidas = "SELECT * FROM tb_itens WHERE idCategoria = ?";
$stmt = $conexao->prepare($query_bebidas);
$stmt->bind_param("i", $categoria_bebida_id);
$stmt->execute();
$resultado_bebidas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebidas - Santo Tempero</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
</head>
<body>
    <header>
        <a href="cardapio.php" class="retornar-btn">Retornar ao Cardápio</a>
        <h1>Bebidas</h1>
    </header>

    <main class="item-container">
        <?php if ($resultado_bebidas->num_rows > 0): ?>
            <?php while ($bebida = $resultado_bebidas->fetch_assoc()): ?>
                <a href="detalhes_item.php?id=<?php echo $bebida['id']; ?>" class="entrada-link">
                <div class="item">
                    <img src="<?php echo htmlspecialchars($bebida['foto']); ?>" alt="<?php echo htmlspecialchars($bebida['nome']); ?>">
                    <h4><?php echo htmlspecialchars($bebida['nome']); ?></h4>
                    <p><?php echo nl2br(htmlspecialchars($bebida['descricao'])); ?></p>
                    <p class="price">Preço: R$ <?php echo number_format($bebida['preco'], 2, ',', '.'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há bebidas disponíveis no momento.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
