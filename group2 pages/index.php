<?php

use Symfony\Component\VarDumper\VarDumper;

$db_name="cafeteria_db";
$db_username="root";
$db_password="root";
$db_host="localhost";

function connect_to_database(){
    global $db_host, $db_username, $db_password, $db_name;
    try{
        $connection = new PDO("mysql:host={$db_host}; dbname={$db_name};",$db_username,$db_password);
        return $connection;
    }catch(PDOException $e){
        echo "Connection failed: ". $e->getMessage();
    }
}

function user_previous_orders(){
    $db_object=connect_to_database();
    try{
        $query="select orders.date,
        products.name,
        order_items.quantity,
        orders.room,
        orders.status,
        orders.total_price
        from orders join order_items 
        on orders.id=order_items.order_id
        join products on products.id=order_items.product_id
        join users on users.id=orders.user_id
        where users.id=1;";
        $stmt=$db_object->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


$res=user_previous_orders();
// var_dump($res);
// foreach($res as $row){
//     echo $row['date']." ".$row['name']." ".$row['quantity']." ".$row['room']." ".$row['status']." ".$row['total_price']."<br>";
// }



function all_products(){
    $db_object=connect_to_database();
    try{
        $query="select name,image 
        from products where id=2;";
        $stmt=$db_object->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}

// var_dump(all_products());



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - my orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="assets/images/logo.jpg" class="Cafeteria-Logo" alt="Cafeteria Logo" class="rounded-circle">
        </a>

        <!-- Navbar Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="manual_order.php">Manual Order</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">My Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
            </ul>

            <!-- Profile Section -->
            <div class="d-flex align-items-center gap-3">
                <div class="admin-profile d-flex align-items-center">
                    <img src="assets/images/profile_img/default.jpg" class="rounded-circle"  height="70">
                    <span class="ms-2 fw-bold">Admin</span>
                </div>
            </div>
        </div>
    </div>
</nav>

<table class="table table-stripped table-sm">
  <thead>
  <?php $i=0;?>
    <tr>
      <th scope="col"></th>
      <th scope="col">Date</th>
      <th scope="col">Product</th>
      <th scope="col">Quantity</th>
      <th scope="col">Room</th>
      <th scope="col">Status</th>
      <th scope="col">Total order</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($res as $res)  
    echo "<tr>
        <th scope='row'><?php echo $i++; ?></th>
        <td>$res[date]</td>
        <td>$res[name]</td>
        <td>$res[quantity]</td>
        <td>$res[room]</td>
        <td>$res[status]</td>
        <td>$res[total_price]</td>
        </tr>"
        ?>
  </tbody>
</table>

<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/myorders_admin.js"></script>
</body>
</html>