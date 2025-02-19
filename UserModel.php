<?php
require 'connection_db.php';

//////////////////// insert
function insert_data($name, $room, $email, $password, $profile_image = "") {
    global $pdo;
    try {
        $inst_query = "INSERT INTO users (name, room, email, password, profile_image) VALUES (:name, :room_no, :email, :password, :image)";
        $stmt = $pdo->prepare($inst_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':room_no', $room);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); 
        $stmt->bindParam(':image', $profile_image);
        $stmt->execute();
        
        if ($pdo->lastInsertId()) {
            echo "Insert Successful";
        }
        $pdo = null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

//////////////////// select data
function select_data(){
    global $pdo;
    try{
        $select_query = "SELECT id, name, room, email, profile_image FROM users";
       $stmt = $pdo->prepare($select_query);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo= null;
       return $result;

    }catch (Exception $e){
        echo "Error($e->getMessage())";
        return false;
    }
}

//////////////////// select User
function select_User($id,$pdo){
    try{
        $select_query = "select * from users where id = :id";
        $stmt = $pdo->prepare($select_query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo= null;
        return $result;
    }catch (PDOException $e){
        echo "Error($e->getMessage())";
    }

}

//////////////////// update User
function update_User($id, $name, $room, $email, $pdo) {
    try {
        $updateQuery = "UPDATE users SET name = :name, room = :room_no, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':room_no', $room);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}



//////////////////// delete user
function delete_user($id){
    global $pdo;
    try{
        $delete_query = "delete from users where id = :id";
        $stmt = $pdo->prepare($delete_query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if($stmt->rowCount()){
            echo "Delete Successful";
        }else{
            echo "Error($e->getMessage())";
        }
        $pdo= null;
    }catch (PDOException $e){
        echo "Error($e->getMessage())";
    }

}
