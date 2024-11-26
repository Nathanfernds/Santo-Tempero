<?php
session_start();

include 'conexao_banco.php';

$categoria_sobremesa_id = 4; 

$query_sobremesas = "SELECT * FROM tb_itens WHERE idCategoria = ?";
$stmt = $conexao->prepare($query_sobremesas);
$stmt->bind_param("i", $categoria_sobremesa_id);
$stmt->execute();
$resultado_sobremesas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobremesas - Santo Tempero</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
</head>
<body>
    <header>
        <a href="cardapio.php" class="retornar-btn">Retornar ao Cardápio</a>
        <h1>Sobremesas</h1>
    </header>

    <main class="item-container">
        <?php if ($resultado_sobremesas->num_rows > 0): ?>
            <?php while ($sobremesa = $resultado_sobremesas->fetch_assoc()): ?>
                <a href="detalhes_item.php?id=<?php echo $sobremesa['id']; ?>" class="entrada-link">
                <div class="item">
                    <img src="<?php echo htmlspecialchars($sobremesa['foto']); ?>" alt="<?php echo htmlspecialchars($sobremesa['nome']); ?>">
                    <h4><?php echo htmlspecialchars($sobremesa['nome']); ?></h4>
                    <p><?php echo nl2br(htmlspecialchars($sobremesa['descricao'])); ?></p>
                    <p class="price">Preço: R$ <?php echo number_format($sobremesa['preco'], 2, ',', '.'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há sobremesas disponíveis no momento.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
