<?php
require 'operations_functions.php';

$pdo = connect_to_db_pdo();

if (!isset($_GET['order_id'])) {
    echo "Invalid request.";
    exit;
}

$orderId = $_GET['order_id'];

$sql = "SELECT oi.quantity, p.name, p.image 
        FROM Order_Items oi
        JOIN Products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['order_id' => $orderId]);
$selectedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($selectedProducts) {
    echo "<div class='row justify-content-center'>";
    foreach ($selectedProducts as $product) {
        echo "<div class='col-md-4 position-relative'>";
        echo "<span class='position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger'>";
        echo "{$product['quantity']}</span>";
        echo "<img src='assets/images/products/{$product['image']}' class='img-fluid rounded' style='width: 13rem; height: 13rem; object-fit: cover;' alt='{$product['name']}'>";
        echo "<div class='card-footer'>";
        echo "<small class='text-body-secondary'>{$product['name']}</small>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p class='text-muted text-center'>No selected products.</p>";
}
?>
