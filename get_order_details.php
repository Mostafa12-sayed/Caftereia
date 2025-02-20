<?php
require 'db/connection_pdo.php';
$pdo = connect_to_db_pdo();

$orderId = $_GET['order_id'] ?? '';

if (!$orderId) {
    echo "Invalid Order ID";
    exit;
}

$query = $pdo->prepare(
"SELECT p.name, oi.quantity, oi.price FROM order_items oi 
JOIN products p ON oi.product_id = p.id 
WHERE oi.order_id = ?"
);
$query->execute([$orderId]);
$orderItems = $query->fetchAll(PDO::FETCH_ASSOC);

if (!$orderItems) {
    echo "No items found for this order.";
} else {
    echo "<ul class='list-group'>";
    foreach ($orderItems as $item) {
     echo "<li class='list-group-item'>{$item['name']} - {$item['quantity']} x {$item['price']} EGP</li>";
    }
    echo "</ul>";
}
