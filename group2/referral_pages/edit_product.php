<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit();
}
$res=[];
if (isset($_GET['id'])){
    $product_id = $_GET['id'];
    $res=fetch_single_product($product_id);
    $categories=all_categories();
}


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

<body style="background-image:url('../bg/bg8.png');">

    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid ">
            <a class="navbar-brand" href="#">
                <img src="../../assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Cafeteria Logo">
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
                            <a href="../../logout.php">Logout</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </nav>





    <div class="col-md-6 container p-4">
        <form action="../submit/submit_edit.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" value="<?=$res['name']?>">
            </div>
            <div class="mb-3 col-md-2">
                <label for="product_price" class="form-label">Price</label>
                <input type="number" class="form-control" name="product_price" value="<?=$res['price']?>">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="available" name="status" id="status" <?php if($res['status']=='available'){echo("checked");} ?>>
                <label class="form-check-label" for="status">
                    Available
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" value="out_of_stock" name="status" id="status" <?php if($res['status']=='out_of_stock'){echo("checked");} ?>>
                <label class="form-check-label" for="status">
                    Out of stock
                </label>
            </div>
            <div class="mb-3 col-md-4">
                <select class="form-select" name="category" aria-label="Select Category">
                    <option >Select Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>" <?php if($category['id']==$res['category_id']){echo "selected";}  ?>><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="image">Upload</label>
                <input type="file" class="form-control" name="image">
                <input type="hidden" name="pimage" id="pimage" value="<?php echo ($res['image']); ?>">
                <input type="hidden" name="id" id="id" value="<?php echo ($product_id); ?>">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="../all_products.php" class="btn btn-secondary">Cancel</a>

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