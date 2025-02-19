<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');

$id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'out_of_stock';



if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $image_ext = explode(".", $image);
    $image_ext = end($image_ext);
    $image_ext = strtolower($image_ext);
    if (in_array($image_ext, array('jpg', 'jpeg', 'png'))&&$_FILES["image"]["size"]<25000000) {
        $file_size = $_FILES["image"]["size"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $image_name ="../uploads/". time() . "_" . $image;
        $moved = move_uploaded_file($file_tmp, "../$image_name");
        if (!$moved) {
            $image_name = null;
        }
        edit_product($id,$name,$price,$category,$image_name,$status);
        unlink("../".$_POST['pimage']);
        }

}else{
    $image = $_POST['pimage'];
    edit_product($id,$name,$price,$category,$image,$status);

}

var_dump($_FILES["image"]["size"]);
header('location:../all_products.php');





?>