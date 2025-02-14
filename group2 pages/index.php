<?php

use Symfony\Component\VarDumper\VarDumper;

require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');

$id = 3;

(isset($_GET['datepicker1'])&& !empty($_GET['datepicker1'])) ? $start_date = $_GET['datepicker1'] : $start_date='2000-01-01' ;
(isset($_GET['datepicker2'])&& !empty($_GET['datepicker2'])) ? $end_date = $_GET['datepicker2'] : $end_date=date('Y-m-d');


if (isset($start_date) && isset($end_date)) {
    $res = user_previous_orders_filtered($id, $start_date, $end_date);
}


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
    <link href="./style/style.css">
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
                    <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="admin-profile d-flex align-items-center" id="profileToggle">
                        <img src="assets/images/profile_img/<?= isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : 'default.jpg' ?>" class="rounded-circle" height="70">
                        <span class="ms-2 fw-bold"><?= $_SESSION['name'] ?></span>
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="#">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </nav>


    <div class="col-8 container">
        <form action="index.php" method="get">
            <h2 class="mb-5">Previos orders</h2>
            <div class="col-12 d-flex p-2 justify-content-around">
                <h5>Pick a date from </h5>
                <div class=" date col-3" data-provide="datepicker">
                    <input type="date" class="form-control" name="datepicker1" id="datepicker1" onchange="start_time();">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <h5>To :</h5>
                <div class=" date col-3" data-provide="datepicker">
                    <input type="date" class="form-control" name="datepicker2" id="datepicker2" onchange="end_time();">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <div>
                    <button id="getDateButton" type="submit" class="btn btn-primary" onclick="apply_date_filter()">Apply</button>
                </div><br><br>
            </div>
            <form>
    <table class="table table-striped" style="background-color: #7e6d63; color:aliceblue; border-radius: 5px;">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">Product</th>
                <th scope="col">Room</th>
                <th scope="col">Status</th>
                <th scope="col">Total order</th>
                <th scope="col">Notes</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; foreach ($res as $row): ?>
                <?php $i++; ?>
                <tr class="clickable_rows">
                    <td scope="row"><?= $i ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['user_name'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['date'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['products_ordered'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['room'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['status'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['total_price'] ?> LE</td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['notes'] ?></td>
                    <td ><button type="button" name="cancel_btn" class="btn btn-danger" <?php if (!($row['status']=='pending')){echo "disabled";} ?>>Cancel</button></td>
                </tr>
                <tr class="collapse" id="show_details<?= $i ?>">
                    <td colspan="9">
                        <div class="details">
                            <h5>Order Details</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?= $row['image'] ?>" class="img-fluid">
                                    <h6 class="mt-3"><?= $row['products_ordered'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>









    <script src="./style/styling.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>