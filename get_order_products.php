<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=cafeteria_db", "root", "root");

// Get the order ID from the request
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Fetch order products
$stmt = $pdo->prepare("SELECT p.name,p.price,p.image, oi.quantity FROM Order_Items oi 
                      JOIN Products p ON oi.product_id = p.id 
                      WHERE oi.order_id = :order_id");
$stmt->execute(['order_id' => $order_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($products);
