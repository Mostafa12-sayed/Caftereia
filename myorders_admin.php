<?php
session_start();
if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header('Location: login.php');
    exit;
}
require_once 'connection_db.php';
require_once 'myorders_function.php';


if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}


$users = getUsers();
$products = getProducts();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
    $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING);
    $products_data = json_decode($_POST['products_json'], true);

    if ($user_id && $room && $products_data) {
        $order_id = createOrder($user_id, $room, $notes, $products_data);

        if ($order_id) {
            header('Location: myorders_admin.php?success=1');
            exit;
        }
    }
    header('Location: myorders_admin.php?error=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/myorders_admin.css" rel="stylesheet">
</head>

<body class="">

<nav class="navbar navbar-expand-lg  bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Cafeteria Logo"  height="70">
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
                <li class="nav-item"><a class="nav-link active fw-bold" href="myorders_admin.php">Manual Order</a></li>
                <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
            </ul>

            <!-- Profile Section -->
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
    </nav>


    <div class="container-fluid py-4">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Order created successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            Please Enter your order.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <?php endif; ?>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Create Order</h5>
                    </div>
                    <div class="card-body">
                        <form id="orderForm" method="POST">
                            <div class="selected-products mb-4"></div>

                            <div class="form-group mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Add special instructions..."></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Room</label>
                                <select class="form-select" name="room" required>
                                    <option value="">Select Room</option>
                                    <option value="room1">Room 1</option>
                                    <option value="room2">Room 2</option>
                                    <option value="room3">Room 3</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <div class="order-total">
                                    <span class="text-muted">Total:</span>
                                    <span class="h5 mb-0 ms-2">EGP 0</span>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Confirm Order
                                </button>
                            </div>
                            <input type="hidden" name="products_json" id="products_json">
                            <input type="hidden" name="user" id="selected_user" value="<?= $users[0]['id'] ?? '' ?>">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Select User</h5>
                            <select class="form-select" id="userSelect" style="width: auto;">
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row row-cols-2 row-cols-md-4 g-4">
                            <?php foreach ($products as $product): ?>
                                <div class="col">
                                    <div class="product-card" data-id="<?= $product['id'] ?>">
                                        <div class="product-image-container">
                                            <img src="assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                                                class="product-image"
                                                alt="<?= htmlspecialchars($product['name']) ?>">
                                        </div>
                                        <div class="product-info">
                                            <h6 class="mb-1"><?= htmlspecialchars($product['name']) ?></h6>
                                            <span class="price"><?= number_format($product['price'], 2) ?> EGP</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/myorders_admin.js"></script>
</body>


</html>