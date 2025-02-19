<?php
require "../UserModel.php";

global $pdo;

$fromDate = $_GET['from_date'] ?? '';
$toDate = $_GET['to_date'] ?? '';
$userId = $_GET['user_id'] ?? '';

$usersQuery = $pdo->query("SELECT id, name FROM users");

$sql = "SELECT o.id, o.date AS order_date, o.total_price AS amount, u.name 
        FROM orders o
        JOIN users u ON o.user_id = u.id WHERE 1=1";

if ($fromDate && $toDate) {
    $sql .= " AND o.date BETWEEN '$fromDate' AND '$toDate'";
}
if ($userId) {
    $sql .= " AND u.id = $userId";
}

$sql .= " ORDER BY o.date DESC";
$orders = $pdo->query($sql);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="../assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Logo" height="70">

            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="../listUsers/allUsers.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="search-container">
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Search products...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <div class="admin-profile">
                        <img src="../assets/images/profile_img/default.jpg" class="rounded-circle" width="40" height="40">
                        <span class="ms-2 fw-bold">admin</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

<div class="container my-1 p-1">
<h2><b> Checks  <b></h2>
<div class="d-flex justify-content-center">
    <form method="GET" class="m-5">
        <label>From: <input type="date" name="from_date" value="<?= $fromDate ?>"></label>
        <label>To: <input type="date" name="to_date" value="<?= $toDate ?>"></label>
        <label>User:
            <select name="user_id">
                <option value="">All Users</option>
                <?php while ($user = $usersQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?= $user['id'] ?>" <?= $userId == $user['id'] ? 'selected' : '' ?>>
                        <?= $user['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>
        <button type="submit" class="btn px-4 m-3 btn-dark">Filter</button>
    </form>
    </div>
    <table class="table table-striped table-hover table-bordered text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['order_date'] ?></td>
                    <td><?= $row['amount'] ?> EGP</td>
                    <td>
                        <button class="btn btn-info btn-sm view-orders" data-id="<?= $row['id'] ?>">+</button>
                    </td>
                </tr>
                <tr id="order-<?= $row['id'] ?>" class="order-details" style="display: none;">
                    <td colspan="4">
                        <div id="order-items-<?= $row['id'] ?>">
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="container text-center m-5">
    <h3>Selected Products</h3>
    <div id="selected-products" class="row justify-content-center m-5"></div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../assets/js/checks.js"></script>
</body>
</html>








