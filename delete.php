<?php

require "./pdo_operations.php";
require_once './connection_db.php';
global $pdo;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    delete_data($id, $pdo);
    if (isset($_GET['image'])) {
        try {
            unlink($_GET['image']);
        } catch (Exception $e) {
            displayError($e->getMessage());
        }
    }
    header("Location: allUsers.php");
} else {
    echo "You did  ";
}
