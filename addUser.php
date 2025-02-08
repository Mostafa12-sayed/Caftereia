<?php

    if (isset($_GET['errors'])){
        $errors = json_decode($_GET['errors'], true);
        extract($errors); 
    }
    if(isset($_GET['old'])){
        $old_data = json_decode($_GET['old'], true);

        if(isset($old_data['name'])){
            $old_name = $old_data['name'];
        }
        if(isset($old_data['password'])){
            $old_password = $old_data['password'];
        }
        if(isset($old_data['email'])){
            $old_email = $old_data['email'];
        }
        if(isset($old_data['ext'])){
            $old_ext = $old_data['ext'];
        }
        if(isset($old_data['room_no'])){
            $old_roomNo = $old_data['room_no'];
        }


    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
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
<div class="right">
    <form action="saveUser.php"  method="post" enctype="multipart/form-data">
        <b class="formHeader">Add User</b>
        <div class="mb-3 input-group">
        <label>Name</label>
            <input type="text" value="<?php echo $old_name ?? ''; ?>"  name="name" class="form-control">     
            </div>
            <p class="text-danger"> <?php echo $name?? "" ?> </p>
        <div class="mb-3 input-group">
        <label>email</label>
            <input type="email"  value="<?php echo $old_email ?? ''; ?>"   name="email"
                   class="form-control" >
        </div>
        <p class="text-danger"> <?php echo $email?? "" ?> </p>
        <div class=" mb-3 input-group">
          <label>Password</label>
          <input type="password" value="<?php echo $old_password ?? ''; ?>"   name="password"
          class="form-control">
        </div>
       <p class="text-danger"><?php echo $password ?? "" ?> </p>
        <div class="mb-3 input-group">
          <label>Confirm Password</label>
          <input type="password" value="<?php echo $old_id ?? ''; ?>"   name="ConPassword"
          class="form-control" >
        </div>
        <p class="text-danger"><?php echo $password ?? "" ?> </p>
        <div class=" mb-3 input-group">
          <label >ext</label>
          <input type="text" value="<?php echo $old_ext ?? ''; ?>"   name="ext"
          class="form-control">          
        </div>
        <p class="text-danger"><?php echo $ext ?? "" ?> </p>
        <div class="mb-3 input-group">
          <label>Room No.</label>
          <input type="number" value="<?php echo $old_roomNo ?? ''; ?>"   name="room_no"
          class="form-control">
        </div>
          <p class="text-danger"><?php echo $room_no ?? "" ?> </p>

       
        <div class="mb-3 input-group ">
            <label >profile Image</label>
            <input type="file"name="image"class="form-control" >
        </div>
        <p class="text-danger"> <?php echo $image?? "" ?> </p>

        <button type="submit" class="btn px-4 btn-dark">Submit</button>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>