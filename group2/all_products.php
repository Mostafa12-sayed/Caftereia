<?php   
require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');
session_start();
if (!isset($_SESSION['user_id'])||$_SESSION['role']!='admin') {
    header('Location: ../login.php');
    exit();
}
if(isset($_GET['res'])) {
    $res = $_GET['res'];
    $res = json_decode(urldecode($res), true);
    }else{
        $res = all_products($limit=10, $offset=0);
    }
    $rows_count=count_all_products();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - ALl Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="./style/style.css" rel="stylesheet">
    
</head>

<body class="" style="background-image:url('./bg/bg6.png'); ">

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


    <div class="col-10 container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3 mt-5" style="color: white;">All products</h2>         
            <a href="admin_add_product.php?>"  class="btn btn-primary ">Add Product</a>
        </div>
    <table class="table table-striped" style="background-color: #7e6d63; color:aliceblue; border-radius: 5px;">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">image</th>
                <th scope="col">Status</th>
                <th scope="col">Category</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; foreach ($res as $row): ?>
                <?php $i++; ?>
                <tr class="clickable_rows">
                    <td scope="row"><?= $i ?></td>
                    <td > <?= $row['name'] ?></td>
                    <td > <?= $row['price'] ?> LE</td>
                    <td><img src="../assets/images/products/<?=$row['image'] ?>" style="width:auto; height:150px; border-radius:5px;" class="img-fluid"></td>
                    <td > <?= $row['status'] ?></td>
                    <td > <?= $row['category'] ?></td>
                    <td ><a href="./referral_pages/edit_product.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a></td>
                    <td ><a href="./referral_pages/delete.php?id=<?= $row['id'] ?>&image=<?= $row['image'] ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12 d-flex justify-content-center">
        <ul class="pagination">
        <?php $totalPages = ceil($rows_count['rows_count'] / 10);
                if ($totalPages > 1) {
                    for ($i = 1; $i <= $totalPages; $i++){?>
                <li class="page-item"><a class="page-link" href="./referral_pages/pagination.php?page_no=<?=$i?>&from=all_products"><?=$i ?></a></li>
                <?php }?>
                <?php ?>
            <?php ;}?>
        </ul>
    </div>









    <script src="./style/styling.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>