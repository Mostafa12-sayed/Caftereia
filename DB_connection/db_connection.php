<?php

$db_name="cafeteria_db";
$db_username="root";
$db_password="root";
$db_host="localhost";

function connect_to_database(){
    global $db_host, $db_username, $db_password, $db_name;
    try{
        $connection = new PDO("mysql:host={$db_host}; dbname={$db_name};",$db_username,$db_password);
        return $connection;
    }catch(PDOException $e){
        echo "Connection failed: ". $e->getMessage();
    }
}


















?>