<?php
include '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $titulo = $_POST['titulo'];

    // Inserir a nova categoria na tabela Categorias
    $sql = "INSERT INTO Categorias (descricao, titulo) VALUES ('$descricao', '$titulo')";
    if ($conn->query($sql) === TRUE) {
        // Armazenar a mensagem de sucesso na sessão
        $_SESSION['message'] = "Categoria adicionada com sucesso!";
    } else {
        // Armazenar a mensagem de erro na sessão
        $_SESSION['message'] = "Erro: " . $conn->error;
    }
}
?>
