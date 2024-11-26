<?php
session_start();

if (isset($_SESSION['pedido'])) {
    unset($_SESSION['pedido']);
}

session_unset();

session_destroy();

header("Location: login.php");
exit();
?>
