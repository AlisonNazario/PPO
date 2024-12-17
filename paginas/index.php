<?php
include '../config/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Livraria</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include '../navbar.php'; ?>
<div class="container">
    <h2>Livros Disponíveis</h2>
    <div class="row">
        <?php
        // Query com JOINs para buscar os dados do livro, autor e categoria
        $sql = "
            SELECT 
                Livro.id, Livro.titulo, Livro.fotoCapa, 
                Autor.nome AS autor, Categorias.descricao AS categoria
            FROM Livro
            INNER JOIN Autor ON Livro.idAutor = Autor.id
            INNER JOIN Categorias ON Livro.idCategoria = Categorias.id
        ";

        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()):
        ?>
            <div class="col-md-3">
                <div class="card position-relative">
                    <?php if (isset($_SESSION['nivelPermissao']) && $_SESSION['nivelPermissao'] == 2): ?>
                        <!-- Ícone de lixeira para admin -->
                        <a href="../classes/Delete.class.php?id=<?= $row['id'] ?>" 
                           class="delete-icon" 
                           onclick="return confirm('Você tem certeza que deseja deletar este livro?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    <?php endif; ?>
                    <img src="<?= $row['fotoCapa'] ?>" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <!-- Título com Categoria -->
                        <h5 class="card-title">
                            <?= $row['titulo'] ?> 
                            <small class="text-muted">(<?= $row['categoria'] ?>)</small>
                        </h5>
                        <p class="card-text"><strong>Autor:</strong> <?= $row['autor'] ?></p>
                        <?php if (isset($_SESSION['nivelPermissao'])): ?>
                            <!-- Botão Adicionar ao Ler -->
                            <a href="../classes/Ler.class.php?id=<?= $row['id'] ?>" class="btn btn-primary">Adicionar à Lista de Leitura</a>
                        <?php else: ?>
                            <!-- Botão que abre o modal se não estiver logado -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Adicionar à Lista de Leitura</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sessão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Você precisa estar logado para adicionar livros ao Lista de leitura.</p>
                <div class="d-flex justify-content-around">
                    <a href="../login/login.php" class="btn btn-primary">Fazer Login</a>
                    <a href="../login/register.php" class="btn btn-secondary">Criar Conta</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
