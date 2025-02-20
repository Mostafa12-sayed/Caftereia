<?php
require_once 'connection_db.php';

function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, name, profile_image FROM Users");
    return $stmt->fetchAll();
}

function getProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM Products WHERE status = 'available'");
    return $stmt->fetchAll();
}

function createOrder($user_id, $room, $notes, $products) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Calculate total
        $total = 0;
        $product_ids = array_column($products, 'id');
        $placeholders = rtrim(str_repeat('?,', count($product_ids)), ',');
        
        $stmt = $pdo->prepare("SELECT id, price FROM Products WHERE id IN ($placeholders)");
        $stmt->execute($product_ids);
        $prices = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        foreach ($products as $product) {
            $total += $prices[$product['id']] * $product['quantity'];
        }
        
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO Orders (user_id, room, notes, total_price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $room, $notes, $total]);
        $order_id = $pdo->lastInsertId();
        
        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO Order_Items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        foreach ($products as $product) {
            $stmt->execute([$order_id, $product['id'], $product['quantity']]);
        }
        
        $pdo->commit();
        return $order_id;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Order creation failed: " . $e->getMessage());
        return false;
    }
}
?>