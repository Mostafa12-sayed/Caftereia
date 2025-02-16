<?php


$file_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';



if (isset($_FILES["image"]["name"])) {
    $image_ext = explode(".", $file_name);
    $image_ext = end($image_ext);
    $image_ext = strtolower($image_ext);
    if (in_array($image_ext, array('jpg', 'jpeg', 'png'))) {
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_name = "../../uploads/" . time() . "_" . $file_name;
        $moved = move_uploaded_file($file_tmp, "$file_name");
        if (!$moved) {
            $file_name = null;
        }
    }
}




?>