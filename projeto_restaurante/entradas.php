<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'conexao_banco.php';

$categoria_entrada_id = 1; 

$query_entradas = "SELECT * FROM tb_itens WHERE idCategoria = $categoria_entrada_id";
$resultado_entradas = mysqli_query($conexao, $query_entradas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas - Santo Tempero</title>
    <link rel="stylesheet" href="includes/CSS/style.css">
    <style>
        
    </style>
</head>
<body>
    <header>
        <a href="cardapio.php" class="retornar-btn">Retornar ao Cardápio</a>
        <h1>Entradas</h1>
    </header>

    <main class="item-container">
        <?php if (mysqli_num_rows($resultado_entradas) > 0): ?>
            <?php while ($entrada = mysqli_fetch_assoc($resultado_entradas)): ?>
                <a href="detalhes_item.php?id=<?php echo $entrada['id']; ?>" class="entrada-link">
                    <div class="item">
                    <img src="<?php echo htmlspecialchars($entrada['foto']); ?>" alt="<?php echo htmlspecialchars($entrada['nome']); ?>">
                        <h4><?php echo htmlspecialchars($entrada['nome']); ?></h4>
                        <p><?php echo nl2br(htmlspecialchars($entrada['descricao'])); ?></p>
                        <p>Preço: R$ <?php echo number_format($entrada['preco'], 2, ',', '.'); ?></p>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há entradas disponíveis no momento.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Santo Tempero. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
