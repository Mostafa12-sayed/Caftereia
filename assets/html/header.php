<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);

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
  <link href="assets/css/orders.css" rel="stylesheet">
  <link href="assets/css/framwork.css" rel="stylesheet">

</head>

<body class="">

  <nav class="navbar navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Cafeteria Logo" height="70">
      </a>

      <!-- Navbar Toggle Button for Mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible Menu -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'index.php') ? 'active fw-bold' : '' ?>" href="index.php">Home</a>
          </li>
          <?php if ($_SESSION['role'] == "admin") { ?>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'products.php') ? 'active fw-bold' : '' ?>" href="products.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'allUsers.php' || $current_page == 'addUser.php' || $current_page == 'editUser.php') ? 'active fw-bold' : '' ?>" href="allUsers.php">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'myorders_admin.php') ? 'active fw-bold' : '' ?>" href="../myorders_admin.php">Manual Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'orders.php') ? 'active fw-bold' : '' ?>" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'checks.php') ? 'active fw-bold' : '' ?>" href="./checks/checks.php">Checks</a>
            </li>
          <?php  } else { ?>

            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'myorders_user.php') ? 'active fw-bold' : '' ?>" href="../myorders_user.php">Manual Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($current_page == 'index.php') ? 'active fw-bold' : '' ?>" href="./group2/index.php">Manual Order</a>
            </li>

          <?php } ?>

        </ul>

        <!-- Profile Section -->
        <div class="d-flex align-items-center gap-3">
          <div class="admin-profile d-flex align-items-center" id="profileToggle">
            <img src="assets/images/profile_img/<?= isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : 'default.jpg' ?>" class="rounded-circle" height="70">
            <span class="ms-2 fw-bold"><?= isset($_SESSION['name']) ? $_SESSION['name'] : '' ?></span>
            <div class="dropdown-menu dropdown-menu-profile" id="dropdownMenu">
              <a href="#" class="d-block">Profile</a>
              <a href="logout.php" class="d-block">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>