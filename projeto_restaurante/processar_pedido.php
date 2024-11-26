<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Usuário não está logado. Redirecionando...";
    header("Location: login.php");
    exit();
}

include('conexao_banco.php');

if (isset($_POST['idItem']) && isset($_POST['quantidade'])) {
    $usuario_id = $_SESSION['usuario']['id'];
    $item_id = (int)$_POST['idItem'];
    $quantidade = (int)$_POST['quantidade'];

    $sql_item = "SELECT * FROM tb_itens WHERE id = ?";
    $stmt_item = $conexao->prepare($sql_item);
    $stmt_item->bind_param("i", $item_id);
    $stmt_item->execute();
    $resultado_item = $stmt_item->get_result();

    if ($resultado_item->num_rows > 0) {
        $item = $resultado_item->fetch_assoc();
        $preco_total = $item['preco'] * $quantidade;

        $sql_pedido = "INSERT INTO tb_itens_pedido (idUsuario, idItem, quantidade, preco) VALUES (?, ?, ?, ?)";
        $stmt_pedido = $conexao->prepare($sql_pedido);
        $stmt_pedido->bind_param("iiid", $usuario_id, $item_id, $quantidade, $preco_total);

        if ($stmt_pedido->execute()) {
            header('Location: pedido.php');
            exit();
        } else {
            echo "Erro ao processar o pedido. Tente novamente.";
        }
    } else {
        echo "Item não encontrado no cardápio.";
    }
} else {
    echo "Por favor, selecione um item e uma quantidade.";
}

?>

<?php if (isset($erro)): ?>
   <p class="erro"><?php echo htmlspecialchars($erro); ?></p>
<?php endif; ?>
 