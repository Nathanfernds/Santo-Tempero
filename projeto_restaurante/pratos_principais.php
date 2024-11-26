<?php

session_start();

include 'conexao_banco.php';

$categoria_pratos_principais_id = 2; 

$query_pratos_principais = "SELECT * FROM tb_itens WHERE idCategoria = ?";
$stmt = $conexao->prepare($query_pratos_principais);
$stmt->bind_param("i", $categoria_pratos_principais_id);
$stmt->execute();
$resultado_pratos_principais = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas - Santo Tempero</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
</head>
<body>
    <header>
        <a href="cardapio.php" class="retornar-btn">Retornar ao Cardápio</a>
        <h1>Pratos Principais</h1>
    </header>

    <main class="item-container">
        <?php if ($resultado_pratos_principais->num_rows > 0): ?>
            <?php while ($pratos_principais = $resultado_pratos_principais->fetch_assoc()): ?>
                <a href="detalhes_item.php?id=<?php echo $pratos_principais['id']; ?>" class="entrada-link">
                <div class="item">
                    <img src="<?php echo htmlspecialchars($pratos_principais['foto']); ?>" alt="<?php echo htmlspecialchars($pratos_principais['nome']); ?>">
                    <h4><?php echo htmlspecialchars($pratos_principais['nome']); ?></h4>
                    <p><?php echo nl2br(htmlspecialchars($pratos_principais['descricao'])); ?></p>
                    <p class="price">Preço: R$ <?php echo number_format($pratos_principais['preco'], 2, ',', '.'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há pratos disponíveis no momento.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
