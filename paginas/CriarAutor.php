<?php
require_once('../classes/CriarAutor.class.php');

if (!isset($_SESSION['nivelPermissao']) || $_SESSION['nivelPermissao'] != 2) {
    // Redireciona para a página de login
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Criar Novo Autor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
<?php include '../navbar.php'; ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="container">
        <div class="alert alert-info">
            <?= $_SESSION['message']; ?>
        </div>
    </div>
    <?php unset($_SESSION['message']); // Limpar a mensagem após exibir ?>
<?php endif; ?>

<div class="container">
    <h2>Adicionar Novo Autor</h2>
    <form method="post">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label for="sobrenome">Sobrenome:</label>
            <input type="text" class="form-control" name="sobrenome" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Autor</button>
        <a href="RegistroLivro.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>