<?php
include '../config/database.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Verifica se foi passado um ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: Ler.php');
    exit();
}

$livro_id = $_GET['id'];

// Busca os dados do livro
$sql = "SELECT 
            l.titulo,
            l.conteudo,
            l.fotoCapa,
            a.nome AS autor,
            c.descricao AS genero
        FROM Livro l
        INNER JOIN Autor a ON l.idAutor = a.id
        INNER JOIN Categorias c ON l.idCategoria = c.id
        WHERE l.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $livro_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ler.php');
    exit();
}

$livro = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lendo: <?= htmlspecialchars($livro['titulo']) ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        .livro-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .livro-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .capa-livro {
            max-width: 200px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .livro-info {
            margin-bottom: 20px;
            color: #666;
        }
        .livro-conteudo {
            font-size: 1.1em;
            line-height: 1.8;
            color: #333;
            text-align: justify;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .controles-leitura {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn-voltar {
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .livro-container {
                padding: 10px;
            }
            .livro-conteudo {
                font-size: 1em;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<?php include '../navbar.php'; ?>

<div class="livro-container">
    <div class="livro-header">
        <img src="<?= htmlspecialchars($livro['fotoCapa']) ?>" alt="Capa do livro" class="capa-livro">
        <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
        <div class="livro-info">
            <p>
                <strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?> |
                <strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?>
            </p>
        </div>
    </div>

    <div class="livro-conteudo">
        <?= nl2br(htmlspecialchars($livro['conteudo'])) ?>
    </div>

    <div class="controles-leitura">
        <a href="Ler.php" class="btn btn-secondary btn-voltar">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <button class="btn btn-primary" id="btnTamanhoFonte">
            <i class="fas fa-font"></i> Tamanho da Fonte
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>

<script>
let tamanhoFonte = 1.1;
const conteudo = document.querySelector('.livro-conteudo');

document.getElementById('btnTamanhoFonte').addEventListener('click', () => {
    tamanhoFonte = tamanhoFonte >= 1.5 ? 1.1 : tamanhoFonte + 0.2;
    conteudo.style.fontSize = `${tamanhoFonte}em`;
});

// Salvar progresso de leitura (exemplo básico)
window.addEventListener('scroll', () => {
    localStorage.setItem(`progresso-livro-${<?= $livro_id ?>}`, window.scrollY);
});

// Restaurar progresso de leitura
window.addEventListener('load', () => {
    const progresso = localStorage.getItem(`progresso-livro-${<?= $livro_id ?>}`);
    if (progresso) {
        window.scrollTo(0, parseInt(progresso));
    }
});
</script>

</body>
</html> 