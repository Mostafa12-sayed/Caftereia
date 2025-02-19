<?php

require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');



if (isset($_GET['id'])&&isset($_GET['image']) &&!empty($_GET['id']) &&!empty($_GET['image'])  ) {
    $id=$_GET['id'];
    $image=$_GET['image'];
    delete_product($id,$image);
}
header('location:../all_products.php');



?>