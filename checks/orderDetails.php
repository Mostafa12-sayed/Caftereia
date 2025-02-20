<?php
require "../pdo_operations.php";
require_once('../connection_db.php'); // تأكد من تضمين ملف الاتصال

global $pdo;

if (!isset($_GET['order_id'])) {
    echo "Invalid request.";
    exit;
}

$orderId = $_GET['order_id'];

$sql = "SELECT oi.quantity, p.name, p.price, p.image 
        FROM Order_Items oi
        JOIN Products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['order_id' => $orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($orderItems) {
    echo "<ul class='list-group'>";
    foreach ($orderItems as $item) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<img src='../assets/images/products/{$item['image']}' alt='{$item['name']}' width='50' height='50' class='rounded-circle'>";
        echo "{$item['name']} - {$item['quantity']} x {$item['price']} EGP";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='text-muted'>No order items found.</p>";
}
