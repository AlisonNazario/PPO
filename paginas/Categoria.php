<?php
require_once('../classes/CriarCategoria.class.php');

if (!isset($_SESSION['nivelPermissao']) || $_SESSION['nivelPermissao'] != 2) {
    // Redireciona para a página de login
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Adicionar Categoria</title>
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
    <h2>Adicionar Nova Categoria</h2>
    <form method="post">
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <input type="text" class="form-control" name="descricao" required>
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Categoria</button>
        <a href="RegistroLivro.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
