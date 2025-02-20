<?php
require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');
$categories = all_categories();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// var_dump($_SESSION['errors']['price']);






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
    <link href="./style/style.css" rel="stylesheet">

</head>

<body style="background-image:url('./bg/bg4.png');">

    <nav class="navbar navbar-expand border-bottom d-flex">
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
                </div>
                <div class="dropdown">
                    <div class="admin-profile d-flex align-items-center" id="profileToggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../assets/images/profile_img/<?= htmlspecialchars($_SESSION['profile_img'] ?? 'default.jpg', ENT_QUOTES, 'UTF-8') ?>" class="rounded-circle" height="70">
                        <span class="ms-2 fw-bold"><?= htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="profileToggle">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="col-md-6 container p-4">
        <form action="submit/submit_add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" required>
            </div>
            <div class="mb-3 col-md-2">
                <label for="product_price" class="form-label">Price</label>
                <input type="number" class="form-control" name="product_price" required>
                <?php if (isset($_SESSION['errors']["price"])){ ?> <p class="is-invalid"><?= $_SESSION['errors']['price'] ?></p><?php }; ?>
            </div>
            <div class="mb-3 col-md-8 d-flex row">
                <div class="mb-3 col-md-6">
                <select class="form-select col-md-12" name="category" aria-label="Select Category" required>
                    <option selected>Select Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="mb-3 col-md-6 row">
                <a href="referral_pages/add_category.php" class="btn btn-info">Add Category</a>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="image">Upload</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="./all_products.php" class="btn btn-secondary">Cancel</a>
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