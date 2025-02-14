<?php
require_once './db/db_connection.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
  // var_dump($_GET['status']);
  $status = $_GET['status'];
  $id = (int) $_GET['id'];
  // var_dump($id);
  $con = OpenCon();  // Ensure this returns a MySQLi connection
  $new_status = ($status === 'completed' ? 'pending' : 'completed');
  // var_dump($new_status);
  $sql = "UPDATE orders SET status = '$new_status' WHERE id = '$id'";
  $con->query($sql);
  // return $new_status;
  // var_dump($new_status);
  $response = [
    'status' => 'success',
    'message' => 'Status changed successfully',
    'new_status' =>  $new_status,
    'order_id' => $id
  ];

  // Set content type to application/json
  header('Content-Type: application/json');

  // Encode response as JSON and output it
  echo  json_encode($response);
}

$orders = get_all_orders();
function get_all_orders()
{
  $con = OpenCon();  // Ensure this returns a MySQLi connection
  $sql = "SELECT orders.*, users.name AS user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC";
  $result = $con->query($sql);
  $orders = [];

  while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
  }

  return $orders;
}


// echo $orders;


// foreach ($orders as $order) {
//   echo "done";
//   echo $order['id'] . " - " . $order['user_id'] . " - " . $order['date'] . $order['user_name'] . "<br>";
// }
