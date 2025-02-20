<?php
session_start();
require "pdo_operations.php";

require "connection_db.php";
global $pdo;
if (isset($_GET['id'])) {
    // $id = json_decode($_GET['id']); // decoding the json 
    $User = select_User($_GET['id'], $pdo);
    // var_dump($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $room = $_POST['room'];
    $email = $_POST['email'];

    $updated = update_User($id, $name, $room, $email, $pdo);

    if ($updated) {
        header("Location: allUsers.php");
        exit();
    } else {
        echo "Error updating User.";
    }
}
?>


<?php include('./assets/html/header.php') ?>
<link href="assets/css/userForm.css" rel="stylesheet">
<div class="container my-3">
    <h3 class="mb-4 text-black border-bottom border-black d-flex justify-content-between align-items-center text-white ">
        <b>Edit User: <?php echo htmlspecialchars($User['name']); ?></b>
        <a href="allUsers.php" class="btn p-3 btn btn-outline-warning m-3">Back to Users</a>
    </h3>
    <div class="card text-white bg-dark mb-3 p-5 w-100 align-items-center" style="width: 50rem;">
        <div class="card-body">
            <form method="POST" action="edit.php?id=<?php echo $User['id']; ?>">
                <input type="hidden" name="id" value="<?php echo $User['id']; ?>">

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($User['name']); ?>" required>
                    <label>Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="room" class="form-control" value="<?php echo htmlspecialchars($User['room']); ?>" required>
                    <label>Room No.</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($User['email']); ?>" required>
                    <label>Email</label>
                </div>

                <button type="submit" class="btn btn-primary"><b>Save</b></button>
            </form>
        </div>
    </div>
</div>

<?php include('./assets/html/footer.php') ?>