<?php
require "db/pdo_operations.php";

if (isset($_GET['id'])) {
    $User = select_User($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $room = $_POST['room'];
    $email = $_POST['email'];

    $updated = update_User($id, $name, $email, $room);

    if ($updated) {
        header("Location: allUsers.php"); 
        exit();
    } else {
        echo "Error updating User.";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-3">
    <h3 class="mb-4 text-black border-bottom border-black">
        <b>Edit User:</b> <?php echo htmlspecialchars($User['name']); ?>
        <a href="allUsers.php" class="btn p-3 m-3 btn-dark">Back to Users</a>
    </h3>

    <div class="card text-white bg-dark mb-3 p-5" style="width: 50rem;">
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
</body>
</html>
