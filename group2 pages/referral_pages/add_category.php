<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../style/style.css" rel="stylesheet">

</head>

<body style="background-image:url('../bg/bg4.png');">

    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid ">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Cafeteria Logo">
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

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
                        <img src="../assets/images/profile_img/<?= isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : 'default.jpg' ?>" class="rounded-circle" height="70">
                       <span class="ms-2 fw-bold">Moaz</span> <!--<?= $_SESSION['name'] ?> here you should replace the Moaz name with this text-->
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="#">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </nav>


    <div class="col-md-12 container p-4 mt-5 d-flex justify-content-center">
        <form action="../submit/submit_add_category.php" method="get">
            <div class="mb-4 col-md-12 ">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="product_name">
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="../admin_add_product.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <style>
    label{
        color:aliceblue;
    }
    </style>


    <script src="./style/styling.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>