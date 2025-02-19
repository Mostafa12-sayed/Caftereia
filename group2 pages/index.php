<?php
require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');

$id = 2;

(isset($_GET['datepicker1'])&& !empty($_GET['datepicker1'])) ? $start_date = $_GET['datepicker1'] : $start_date='2000-01-01' ;
(isset($_GET['datepicker2'])&& !empty($_GET['datepicker2'])) ? $end_date = $_GET['datepicker2'] : $end_date=date('Y-m-d');


if(isset($_GET['res'])) {
    $res = $_GET['res'];
    $res = json_decode(urldecode($res), true);
    }else{
    $res = user_previous_orders_filtered($id, $start_date, $end_date,$offset=0, $limit=10);
}
$rows_count=count_selected_rows($id, $start_date, $end_date);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - my orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="./style/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="">
    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid ">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logo.jpg" class="Cafeteria-Logo rounded-circle" alt="Cafeteria Logo">
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
                    <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="admin-profile d-flex align-items-center" id="profileToggle">
                        <img src="../assets/images/profile_img/<?= isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : 'default.jpg' ?>" class="rounded-circle" height="70">
                       <span class="ms-2 fw-bold">Moaz</span> <!--<?= $_SESSION['name'] ?> here you should replace the Moaz name with this text-->
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="#">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </nav>

    <div class="col-11 container">
        <form action="index.php" method="get">
            <h2 class="mb-5 mt-5" style="color:azure">Previos orders</h2>
            <div class="col-12 d-flex p-2 justify-content-around mt-3">
                <h5 style="color:azure">Pick a date from </h5>
                <div class=" date col-3" data-provide="datepicker">
                    <input type="date" class="form-control" name="datepicker1" id="datepicker1" >
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <h5 style="color:azure">To :</h5>
                <div class=" date col-3" data-provide="datepicker">
                    <input type="date" class="form-control" name="datepicker2" id="datepicker2">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <div>
                    <button id="getDateButton" type="submit" class="btn btn-primary">Apply</button>
                </div><br><br>
            </div>
        </form>
        <table class="table table-striped" style="background-color: #7e6d63; color:aliceblue; border-radius: 5px;">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total order</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($res as $row): ?>
                    <?php $i++; ?>
                    <tr class="clickable_rows" order_id=<?=$row['id'] ?>>
                        <td scope="row"><?= $i ?></td>
                        <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['user_name'] ?></td>
                        <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['date'] ?></td>
                        <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['status'] ?></td>
                        <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['total_price'] ?> LE</td>
                        <td ><button type="button" onclick="window.location.href='referral_pages/cancelling_order.php?id=<?php echo $row['id']; ?>'" name="cancel_btn" class="btn btn-danger" <?php if (!($row['status']=='pending')){echo "disabled";} ?>>Cancel</button></td>
                    </tr>
                    <tr class="collapse" id="show_details<?= $i ?>">
                        <td colspan="9" data-bs-toggle="collapse" href="#show_details<?= $i ?>">
                            <div class=" col-md-12 details d-flex justify-content-center row" style="--bs-gutter-x: 0rem;">
                                <div class=" d-flex justify-content-center">
                                    <h5>Order Details</h5>
                                </div>
                                <div class="col-md-12 row justify-content-center align-items-baseline">
                                    <?php $items=array_map(null,explode(',',$row['product_images']),explode(',',$row['products_ordered']));
                                        foreach($items as list ($image,$name)){?>
                                        <div class="col-md-3 d-flex justify-content-center flex-column align-items-center" >
                                            <img src="<?= $image ?>" style="border-radius: 10px; padding:5px;" width=150px >
                                            <h6><?=$name ?></h6>
                                        </div>
                                    <?php }?>
                                    <div class="col-md-12 d-flex justify-content-evenly"> 
                                        <p><b>Room: <?= $row['room'] ?></b> </p>
                                        <p><b>Notes: <?= $row['notes'] ?></b></p>
                                        <p><b>Total Order: <?= $row['total_price'] ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 d-flex justify-content-center">
        <ul class="pagination">
            <?php for ($i=1; $i <= ceil($rows_count['rows_count']/10); $i++) { 
                      if(ceil($rows_count['rows_count']/10)>1){ ?>
                <li class="page-item"><a class="page-link" href="./referral_pages/pagination.php?page_no=<?=$i?>&user_id=<?=$id?>&strt_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$i ?></a></li>
                <?php }?>
                <?php ?>
            <?php ;}?>
        </ul>
    </div>










    <script src="./style/styling.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>