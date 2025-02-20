<?php
session_start();
if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
    extract($errors);
}
if (isset($_GET['old'])) {
    $old_data = json_decode($_GET['old'], true);

    if (isset($old_data['name'])) {
        $old_name = $old_data['name'];
    }
    if (isset($old_data['password'])) {
        $old_password = $old_data['password'];
    }
    if (isset($old_data['email'])) {
        $old_email = $old_data['email'];
    }
    if (isset($old_data['ext'])) {
        $old_ext = $old_data['ext'];
    }
    if (isset($old_data['room_no'])) {
        $old_roomNo = $old_data['room_no'];
    }
}
?>

<?php include('./assets/html/header.php') ?>
<link href="assets/css/userForm.css" rel="stylesheet">

<div class="container">
    <div class="right">
        <form action="saveUser.php" method="post" enctype="multipart/form-data">
            <b class="formHeader">Add User</b>
            <div class="mb-3 input-group">
                <label>Name</label>
                <input type="text" value="<?php echo $old_name ?? ''; ?>" name="name" class="form-control">
            </div>
            <p class="text-danger"> <?php echo $name ?? "" ?> </p>
            <div class="mb-3 input-group">
                <label>email</label>
                <input type="email" value="<?php echo $old_email ?? ''; ?>" name="email"
                    class="form-control">
            </div>
            <p class="text-danger"> <?php echo $email ?? "" ?> </p>
            <div class=" mb-3 input-group">
                <label>Password</label>
                <input type="password" value="<?php echo $old_password ?? ''; ?>" name="password"
                    class="form-control">
            </div>
            <p class="text-danger"><?php echo $password ?? "" ?> </p>
            <div class="mb-3 input-group">
                <label>Confirm Password</label>
                <input type="password" value="<?php echo $old_id ?? ''; ?>" name="ConPassword"
                    class="form-control">
            </div>
            <p class="text-danger"><?php echo $password ?? "" ?> </p>
            <div class="mb-3 input-group">
                <label>ext</label>
                <input type="text" value="<?php echo $old_ext ?? ''; ?>" name="ext"
                    class="form-control">
            </div>
            <p class="text-danger"><?php echo $ext ?? "" ?> </p>
            <div class="mb-3 input-group">
                <label>Room No.</label>
                <input type="number" value="<?php echo $old_roomNo ?? ''; ?>" name="room_no"
                    class="form-control">
            </div>
            <p class="text-danger"><?php echo $room_no ?? "" ?> </p>


            <div class="mb-3 input-group ">
                <label>profile Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <p class="text-danger"> <?php echo $image ?? "" ?> </p>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php include('./assets/html/footer.php') ?>