<?php
require_once('./connection_db.php'); // تأكد من تضمين ملف الاتصال
global $pdo;
if (isset($_GET['customer_name'])) {
  filterOrder($_GET['customer_name'], $pdo);
}
if (isset($_GET['id']) && isset($_GET['status'])) {

  $new_status = $_GET['status'];
  $id = (int) $_GET['id'];
  $sql = "UPDATE orders SET status = '$new_status' WHERE id = '$id'";
  $pdo->query($sql);
  $response = [
    'status' => 'success',
    'message' => 'Status changed successfully',
    'new_status' =>  $new_status,
    'order_id' => $id
  ];
  header('Content-Type: application/json');
  echo  json_encode($response);
}
$orders = get_all_orders($pdo);
function get_all_orders($pdo)
{
  $sql = "SELECT orders.*, users.name AS user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC";
  $result = $pdo->query($sql);
  $orders = [];

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $orders[] = $row;
  }

  return $orders;
}

function filterOrder($customer_name, $pdo)
{
  $orders = [];
  $sql = "SELECT orders.*, users.name 
      FROM orders 
      JOIN users ON orders.user_id = users.id
      WHERE users.name LIKE '%$customer_name%'";

  $result = $pdo->query($sql);

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $orders[] = $row;
  }


  header('Content-Type: application/json');
  echo  json_encode($orders);
}
