<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');

$id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : $_POST['pimage'];

var_dump($_FILES['image']['name']);
var_dump($_POST['pimage']);

if (isset($_FILES["image"]["name"])) {
    $image_ext = explode(".", $image);
    $image_ext = end($image_ext);
    $image_ext = strtolower($image_ext);
    if (in_array($image_ext, array('jpg', 'jpeg', 'png'))) {
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $image_name ="../uploads/". time() . "_" . $image;
        $moved = move_uploaded_file($file_tmp, "../$image_name");
        if (!$moved) {
            $image_name = null;
        }
        edit_product($id,$name,$price,$category,$image_name);
        unlink("../".$_POST['pimage']);
    }
}else{
    edit_product($id,$name,$price,$category,$image);
}


header('location:../all_products.php');





?>