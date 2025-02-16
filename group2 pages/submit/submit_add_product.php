<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');

 isset($_FILES['image']['name']) ? $file_name = $_FILES['image']['name'] : $file_name ='';
 isset($_POST['product_name']) ? $product_name = $_POST['product_name'] : $product_name ='';
 isset($_POST['product_price']) ? $product_price = $_POST['product_price'] : $product_price ='';
 isset($_POST['category']) ? $product_category = $_POST['category'] : $product_category ='';


if (isset($_FILES["image"]["name"])) {
    $image_ext = explode(".", $file_name);
    $image_ext = end($image_ext);
    $image_ext = strtolower($image_ext);
    if (in_array($image_ext, array('jpg', 'jpeg', 'png'))) {
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_name ="../uploads/". time() . "_" . $file_name;
        $moved = move_uploaded_file($file_tmp, "../$file_name");
        echo "Image uploaded successfully";
        if (!$moved) {
            $file_name = null;
        }
    }
}

add_product($product_name,$product_price,$product_category,$file_name);

header('location:../all_products.php');

?>