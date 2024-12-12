<?php
include '../classes/Compra.class.php';
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Retrieve cart items and calculate total

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
<?php include '../navbar.php'; ?>
<div class="container">
    <h2>Finalizar Compra</h2>
    <h3>Total: $<?= number_format($totalPrice, 2) ?></h3>
    <form method="post">

    <label for="descricao">CPF:</label>
    <input type="text" class="form-control" name="cpf" required>

        <button type="submit" class="btn btn-primary">Completar Compra</button>
        <a href="Carrinho.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
