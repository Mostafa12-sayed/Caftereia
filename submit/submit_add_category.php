<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');


 isset($_GET['product_name']) ? $c_name = $_GET['product_name'] : $c_name ='';

add_category($c_name);

header('location:../admin_add_product.php');

?>