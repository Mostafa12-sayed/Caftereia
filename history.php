<?php
require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
$id = $_SESSION['user_id'];

(isset($_GET['datepicker1']) && !empty($_GET['datepicker1'])) ? $start_date = $_GET['datepicker1'] : $start_date = '2000-01-01';
(isset($_GET['datepicker2']) && !empty($_GET['datepicker2'])) ? $end_date = $_GET['datepicker2'] : $end_date = date('Y-m-d');

if (isset($_GET['res'])) {
    $res = $_GET['res'];
    $res = json_decode(urldecode($res), true);
} else {
    $res = user_previous_orders_filtered($id, $start_date, $end_date, $offset = 0, $limit = 10);
}
$rows_count = count_selected_rows($id, $start_date, $end_date);

?>
<?php include('./assets/html/header.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="./assets/css/style_my_orders.css" rel="stylesheet">


<div class="col-11 container">
    <form action="index.php" method="get" id="date_form">
        <h2 class="mb-5 mt-5" style="color:azure">Previos orders</h2>
        <div class="col-12 d-flex p-2 justify-content-around mt-3">
            <h5 style="color:azure">Pick a date from </h5>
            <div class=" date col-3" data-provide="datepicker">
                <input type="date" class="form-control" name="datepicker1" id="datepicker1">
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
                <button id="getDateButton" type="submit" class="btn btn-success">Apply</button>
                <button id="getDateButton" type="reset" class="btn btn-dark" id="reset_data">Reset</button>
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
            <?php $i = 0;
            foreach ($res as $row): ?>
                <?php $i++; ?>
                <tr scope="row" class="clickable_rows" order_id=<?= $row['id'] ?>>
                    <td scope="row"><?= $i ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['user_name'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['date'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['status'] ?></td>
                    <td data-bs-toggle="collapse" href="#show_details<?= $i ?>"> <?= $row['total_price'] ?> LE</td>
                    <td><button type="button" onclick="window.location.href='referral_pages/cancelling_order.php?id=<?php echo $row['id']; ?>'" name="cancel_btn" class="btn btn-danger" <?php if (!($row['status'] == 'pending')) {
                     echo "disabled";} ?>>Cancel</button></td>
                </tr>
                <tr scope="row" class="collapse" id="show_details<?= $i ?>">
                    <td colspan="9" data-bs-toggle="collapse" href="#show_details<?= $i ?>">
                        <div class=" col-md-12 details d-flex justify-content-center row" style="--bs-gutter-x: 0rem;">
                            <div class=" d-flex justify-content-center">
                                <h5>Order Details</h5>
                            </div>
                            <div class="col-md-12 row justify-content-center align-items-baseline">
                                <?php $items = array_map(null, explode(',', $row['product_images']), explode(',', $row['products_ordered']));
                                foreach ($items as list($image, $name)) { ?>
                                    <div class="col-md-3 d-flex justify-content-center flex-column align-items-center">
                                        <img src="./assets/images/products/<?= $image ?>" style="width:175px; height:150px; border-radius:5px; padding:5px;" width=150px>
                                        <h6><?= $name ?></h6>
                                    </div>
                                <?php } ?>
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
        <?php $totalPages = ceil($rows_count['rows_count'] / 10);
        if ($totalPages > 1) {
            for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item"><a class="page-link" href="./referral_pages/pagination.php?page_no=<?= $i ?>&user_id=<?= $id ?>&strt_date=<?= $start_date ?>&end_date=<?= $end_date ?>"><?= $i ?></a></li>
            <?php } ?>
            <?php ?>
        <?php
        } ?>
    </ul>
</div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="./style/styling.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
