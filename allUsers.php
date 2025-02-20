<?php
session_start();
if (!isset($_SESSION['login']) || ($_SESSION['role'] ?? '') !== 'admin') {
    // header('Location: myorders_user.php');
    // exit;
}
require_once "./connection_db.php";
require "./pdo_operations.php";



global $pdo;
$users =  select_data($pdo);
?>

<?php include('./assets/html/header.php') ?>

<link rel="stylesheet" href="assets/css/userForm.css">



<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-sm-4">
                    <h2>All <b>Users</b></h2>

                </div>
                <a href="addUser.php" class="btn p-2 btn-primary btnAdd"><b> Add User</b> </a>
            </div>
        </div>
        <div class="table-filter">
            <div class="row">
                <div class="d-flex justify-content-between " id=filter>
                    <div>
                        <button type="button" onclick="filterOrders()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <div class="filter-group">
                            <input type="text" id="customerName" class="form-control" placeholder="Enter Customer name">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="table-aria">
            <table class="table table-striped table-hover orders-table" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Room No.</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr id="row-<?php echo $user['id']; ?>">
                            <td><?php echo $user['id']; ?></td>
                            <td style="cursor: pointer;" onclick="toggleDetails(<?php echo $user['id']; ?>)">
                                <?php echo ($user['name']); ?>
                            </td>
                            <td> <?php echo ($user['room']); ?> </td>
                            <td> <?php echo ($user['email']); ?> </td>
                            <td>
                                <img src="<?php echo ($user['profile_image']) ? $user['profile_image'] : 'assets/images/profile_img/default.png'; ?>" width="40" height="40">
                            </td>
                            <td width="150">
                                <a href="edit.php?id=<?php echo urlencode($user['id']); ?>"
                                    class="view pending" title="Edit User" data-toggle="tooltip">
                                    <i class="fa-solid fa-pen"></i> </a>
                                <a href="delete.php?id=<?php echo $user['id'] ?>&image=<?php echo $user['profile_image']; ?>"
                                    class="view text-danger" title="Delete User" data-toggle="tooltip">
                                    <i class="fa-solid fa-trash"></i>
                                </a>


                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>


<!-- <div class="container my-1 p-1">
    <div class=" d-flex justify-content-between align-items-center">
        <small class="mb-4 formHeader">All Users
        </small>
        <a href="addUser.php" class="btn p-2 btn-primary btnAdd"><b> Add User</b> </a>
    </div>


    // function drawTable($users)
    // {
    //     echo "<table class='table table-striped table-hover'>";
    //     echo "<tr> 
    // <th> ID</th> 
    // <th> Name</th>  
    //    <th>room No.</th>
    //    <th>email</th>
    //     <th>Image</th> 
    //     <th>Update</th>
    //      <th>Delete</th>
    //       </tr>";
    //     foreach ($users as $user) {
    //         echo "<tr>";
    //         foreach ($user as $key => $value) {

    //             if ($key != "profile_image") {
    //                 echo "<td>{$value}</td>";
    //             } else {
    //                 echo "<td><img src='{$value}' width='40' height='40'></td>";
    //             }
    //         }
    //         echo "<td><a class='btn btn-outline-primary' href='edit.php?id={$user['id']}'>Update</a></td>";
    //         echo "<td><a class='btn btn-outline-danger' href='delete.php?id={$user['id']}&image={$user['profile_image']}'>Delete</a></td>";
    //         echo "</tr>";
    //     }

    //     echo "</table>";
    // }

    // drawTable($user);
    // 
    ?> -->

<?php include('./assets/html/footer.php') ?>