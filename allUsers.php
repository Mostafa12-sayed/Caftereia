<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <title>Add New User </title>
    <link rel="stylesheet" href="assets/css/userForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo.png" alt="Cafeteria Logo" height="40">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="allUsers.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="search-container">
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Search products...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <div class="admin-profile">
                        <img src="assets/images/admin-avatar.png" class="rounded-circle" width="40" height="40">
                        <span class="ms-2 fw-bold">admin</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-1 p-1">
        <b class="mb-4 formHeader">All Users
        </b>
        <a href="addUser.php" class="btn p-3 m-3 btn-dark btnAdd"><b> Add User</b> </a>


        <?php

        require "db/pdo_operations.php";
        function drawTable($users)
        {
            echo "<table class='table table-striped table-hover'>";
            echo "<tr> 
                    <th> ID</th> 
                    <th> Name</th>  
                    <th>room No.</th>
                    <th>email</th>
                    <th>Image</th> 
                    <th>Update</th>
                    <th>Delete</th>
                </tr>";
            foreach ($users as $user) {
                echo "<tr>";
                foreach ($user as $key => $value) {

                    if ($key != "profile_image") {
                        echo "<td>{$value}</td>";
                    } else {
                        echo "<td><img src='{$value}' width='40' height='40'></td>";
                    }
                }
                // echo "<td><a class='btn btn-outline-warning' href='show.php?id={$user['id']}'>Show</a></td>";
                echo "<td><a class='btn btn-outline-primary' href='edit.php?id={$user['id']}'>Update</a></td>";
                echo "<td><a class='btn btn-outline-danger' href='delete.php?id={$user['id']}&image={$user['profile_image']}'>Delete</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        }

        $user =  select_data();
        drawTable($user);
        ?>