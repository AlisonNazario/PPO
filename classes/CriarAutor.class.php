<?php
include '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];

    // Insere o novo autor no banco de dados
    $sql = "INSERT INTO Autor (nome, sobrenome) VALUES ('$nome', '$sobrenome')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Autor adicionado com sucesso.";
    } else {
        $_SESSION['message'] = "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

