<?php
require_once('../classes/RegistroLivro.class.php');
include '../config/database.php';

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['nivelPermissao']) || $_SESSION['nivelPermissao'] != 2) {
    header("Location: ../paginas/index.php");
    exit();
}



$registroLivro = new RegistroLivro($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $anoPublicacao = $_POST['anoPublicacao'];
    $fotoCapa = $_POST['fotoCapa'];
    $idCategoria = $_POST['idCategoria'];
    $idAutor = $_POST['idAutor'];

    @$resultado = $registroLivro->adicionarLivro($titulo, $anoPublicacao, $fotoCapa, $idCategoria, $preco, $idAutor);


    $_SESSION['message'] = $resultado;
}

// Obtém as categorias e autores para preencher os selects
$categorias = $registroLivro->obterCategorias();
$autores = $registroLivro->obterAutores();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adicionar Livro</title>
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
    <h2>Adicionar Novo Livro</h2>
    <form method="post">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="anoPublicacao">Ano de Publicação:</label>
            <input type="number" class="form-control" name="anoPublicacao">
        </div>
        <div class="form-group">
            <label for="fotoCapa">URL da Foto de Capa:</label>
            <input type="text" class="form-control" name="fotoCapa">
        </div>
        <div class="form-group">
            <label for="idCategoria">Categoria:</label>
            <select class="form-control" name="idCategoria" required>
                <option value="">Selecione uma Categoria</option>
                <?php while ($categoria = $categorias->fetch_assoc()): ?>
                    <option value="<?= $categoria['id']; ?>"><?= $categoria['titulo']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="idAutor">Autor:</label>
            <select class="form-control" name="idAutor" required>
                <option value="">Selecione um Autor</option>
                <?php while ($autor = $autores->fetch_assoc()): ?>
                    <option value="<?= $autor['id']; ?>"><?= $autor['nome']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar Livro</button>
    </form>
    <br>
    <!-- Botões para redirecionar para a página de criação de categoria e autor -->
    <a href="Categoria.php" class="btn btn-secondary">Criar Nova Categoria</a>
    <a href="CriarAutor.php" class="btn btn-secondary">Criar Novo Autor</a>
</div>
</body>
</html>
