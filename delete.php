<?php

require "db/pdo_operations.php";


if(isset($_GET["id"])){
    $id = $_GET["id"];
    delete_data($id);
    if(isset($_GET['image'])){
        try{
            unlink($_GET['image']);
        }catch (Exception $e){
            displayError($e->getMessage());
        }
    }
    header("Location: allUsers.php");
}else{
    echo "You did  ";
}

