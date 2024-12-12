<?php
include '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM Usuario WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nivelPermissao'] = $user['nivelPermissao']; // Armazenando o nível de permissão
            header("Location: ../paginas/index.php");
        } else {
            echo "Credenciais inválidas";
        }
    } else {
        echo "Usuário não encontrado";
    }
}
?>
