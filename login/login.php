<?php
require_once('../classes/Login.class.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
<?php include '../navbar.php'; ?>
<div class="container">
    <h2>Login</h2>
    <form method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br>
    <!-- Botão de registro para redirecionar para register.php -->
    <a href="register.php" class="btn btn-secondary">Registrar</a>
</div>
</body>
</html>
