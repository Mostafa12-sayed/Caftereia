<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');


 isset($_FILES['image']['name']) ? $file_name = $_FILES['image']['name'] : $file_name ='';
 isset($_POST['product_name']) ? $product_name = $_POST['product_name'] : $product_name ='';
 isset($_POST['product_price']) ? $product_price = $_POST['product_price'] : $product_price ='';
 isset($_POST['category']) ? $product_category = $_POST['category'] : $product_category ='';

$errors = [];

if (empty($_POST['product_name'])) {
    $errors["name"] = "Product name is required.";
}else{
    $product_name = $_POST['product_name'];
}

if (empty($_POST['product_price']) || !is_numeric($_POST['product_price']) || $_POST['product_price'] <= 0) {
    $errors["price"] = "Price must be a valid number greater than 0.";
}else{
    $product_price = $_POST['product_price'];
}

if (empty($_POST['category'])) {
    $errors[] = "Category is required.";
}else{
    $product_category = $_POST['category'];
}
if (empty($_FILES['image']['name'])) {
    $errors[] = "Image is required.";
}else {
    $image_ext = explode(".", $file_name);
    $image_ext = end($image_ext);
    $image_ext = strtolower($image_ext);
    $file_size = $_FILES["image"]["size"];
    if (in_array($image_ext, array('jpg', 'jpeg', 'png'))&& $file_size < 2000000) {
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_name = time() . "_" . $file_name;
        $moved = move_uploaded_file($file_tmp, "../assets/images/products/$file_name");
        if(!$moved){
            echo "Failed to move uploaded file.";
        }
    }else {
        $errors[] = "Image extention can be 'jpg', 'jpeg', 'png' and file size should be less than 2MB.";
    }

}
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../admin_add_product.php');
    exit();
}

add_product($product_name,$product_price,$product_category,$file_name);

header('location:../all_products.php');

?>