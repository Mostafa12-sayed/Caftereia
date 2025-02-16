<?php

require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    delete_product($id);
}
header('location:all_products.php');



?>