<?php

$totalPrice = 0;
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(",", $_SESSION['cart']);
    $sql = "SELECT * FROM Livro WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $totalPrice += $row['preco'];
    }
}

// Process the purchase
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dtCompra = date('Y-m-d');
    $sqlCompra = "INSERT INTO Compra (dtCompra, valorTotalCompra) VALUES ('$dtCompra', '$totalPrice')";
    if ($conn->query($sqlCompra) === TRUE) {
        $compraId = $conn->insert_id;
        
        foreach ($cartItems as $item) {
            $sqlItensCompra = "INSERT INTO ItensCompra (idLivro, idCompra, valorUnitario, quantidade, valorTotalItem) 
                               VALUES ('{$item['id']}', '$compraId', '{$item['preco']}', 1, '{$item['preco']}')";
            $conn->query($sqlItensCompra);
        }
        
        // Clear the cart after purchase
        $_SESSION['cart'] = [];
        
        echo "<div class='alert alert-success'>Purchase completed successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}