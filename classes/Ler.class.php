<?php
include '../config/database.php';
session_start();

// Inicializa o carrinho como array associativo, se ainda não existir
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Adiciona um livro ao carrinho
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Verifica se o livro já está no carrinho
    if (isset($_SESSION['cart'][$bookId])) {
        $_SESSION['cart'][$bookId]['quantity'] += 1; // Incrementa a quantidade
    } else {
        // Consulta os dados do livro
        $sql = "SELECT id, titulo, preco, idCategoria AS genero FROM Livro WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $_SESSION['cart'][$bookId] = [
                'titulo' => $book['titulo'],
                'genero' => $book['genero'],
                'preco' => $book['preco'],
                'quantity' => 1,
            ];
        }
    }

    header("Location: ../paginas/Carrinho.php");
    exit();
}

// Atualiza a quantidade de itens no carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $bookId = $_POST['book_id'];
    $newQuantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$bookId])) {
        if ($newQuantity > 0) {
            $_SESSION['cart'][$bookId]['quantity'] = $newQuantity;
        } else {
            unset($_SESSION['cart'][$bookId]); // Remove o item se a quantidade for 0
        }
    }
    header("Location: ../paginas/Carrinho.php");
    exit();
}

// Remove um item do carrinho
if (isset($_GET['remove'])) {
    $bookId = $_GET['remove'];
    if (isset($_SESSION['cart'][$bookId])) {
        unset($_SESSION['cart'][$bookId]);
    }
    header("Location: ../paginas/Carrinho.php");
    exit();
}

// Busca detalhes dos livros no carrinho
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $details) {
        $cartItems[$id] = $details;
    }
}
?>
