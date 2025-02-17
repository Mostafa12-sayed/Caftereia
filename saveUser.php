<?php

require "db/pdo_operations.php";

$name = $_POST['name'];
$room_no = $_POST['room_no'];
$email = $_POST['email'];
$password = $_POST['password'];
$image= $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];




if($name and $room_no and $email and $password and $image  and $image_size  ){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $image_name = "uploads/".time()."_".$image;
    $uploaded = move_uploaded_file($_FILES['image']['tmp_name'], $image_name);
    if(! $uploaded){
        $image_name=null;
    }

    $inserted =insert_data($name, $room_no, $email, $hashed_password, $image_name);



    header("Location: allUsers.php");
}

else{
    $errors = [];
    $old =[];
    foreach ($_POST as $key => $value) {
        if (! $value){
            $errors[$key] = "Please enter a {$key}";
        }else{
            $old[$key] = $value;
        }
    }
    if(! $image){
        $errors['image'] = "Please select a image";
    }

    print_r($errors);
 
    $errors = json_encode($errors);

    $url  = "Location: addUser.php?errors={$errors}";

    if(count($old)){
        $old = json_encode($old);
        $url  = "{$url}&old={$old}";
    }
    header($url);
}

