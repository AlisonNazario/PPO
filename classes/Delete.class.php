<?php
include '../config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Primeiro, exclua os registros relacionados na tabela itenscompra
    $sqlItensCompra = "DELETE FROM itenscompra WHERE idLivro = ?";
    $stmtItensCompra = $conn->prepare($sqlItensCompra);
    $stmtItensCompra->bind_param("i", $id);

    if (!$stmtItensCompra->execute()) {
        echo "Erro ao excluir os itens relacionados: " . $conn->error;
        exit;
    }

    // Em seguida, exclua o livro
    $sql = "DELETE FROM Livro WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../paginas/index.php?message=Livro+excluído+com+sucesso");
        exit;
    } else {
        echo "Erro ao excluir o livro: " . $conn->error;
    }
} else {
    header("Location: ../paginas/index.php?error=ID+inválido");
    exit;
}
?>
