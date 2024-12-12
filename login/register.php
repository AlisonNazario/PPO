<?php
include '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $nivelPermissao = $_POST['nivelPermissao'];
    
    // Verifica se o email já existe
    $checkEmail = "SELECT id FROM Usuario WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Este email já está cadastrado.";
    } else {
        // Insere novo usuário
        $sql = "INSERT INTO Usuario (nome, email, senha, nivelPermissao) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $senha, $nivelPermissao);
        
        if ($stmt->execute()) {
            // Faz login automático após o registro
            $userId = $conn->insert_id;
            $_SESSION['user_id'] = $userId;
            $_SESSION['nome'] = $nome;
            $_SESSION['nivelPermissao'] = $nivelPermissao;
            
            header("Location: ../paginas/index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include '../navbar.php'; ?>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Cadastro</h2>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" required 
                       value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required
                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" name="senha" required>
            </div>
            
            <div class="form-group">
                <label for="nivelPermissao">Tipo de Conta:</label>
                <select class="form-control" name="nivelPermissao" required>
                    <option value="1">Leitor</option>
                    <option value="2">Escritor</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Criar Conta</button>
            
            <div class="text-center mt-3">
                <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
