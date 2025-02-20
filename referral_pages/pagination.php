<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');


if (isset($_GET['user_id'])) {
    (isset($_GET['user_id'])) ? $id = $_GET['user_id'] : "";
    (isset($_GET['page_no'])) ? $page = $_GET['page_no'] : $page = 1;

    $limit = 10;
    $offset = ($page - 1) * $limit;

    (isset($_GET['datepicker1']) && !empty($_GET['datepicker1'])) ? $start_date = $_GET['datepicker1'] : $start_date = '2000-01-01';
    (isset($_GET['datepicker2']) && !empty($_GET['datepicker2'])) ? $end_date = $_GET['datepicker2'] : $end_date = date('Y-m-d');


        if (isset($start_date) && isset($end_date)) {
            $res = user_previous_orders_filtered($id, $start_date, $end_date, $offset, $limit);

            $json_data = urlencode(json_encode($res));
            header("Location:../history.php?res=$json_data");
            exit;
        }

} elseif ($_GET['from']=='all_products') {
    (isset($_GET['page_no'])) ? $page = $_GET['page_no'] : $page = 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $res = all_products($limit, $offset);
    $json_data = urlencode(json_encode($res));
    header("Location:../all_products.php?res=$json_data");
    exit;
} else {
    $res = [];
    header("Location:../all_products.php?res=no_data");
    exit;
}
