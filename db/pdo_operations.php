<?php

require 'connection_pdo.php';


function insert_data($name, $room_no, $email, $image = "")
{
    $pdo = connect_to_db_pdo();
    try {
        $inst_query = "insert into users (name, room_no,email, image) values (:name, :addr, :email, :image )";
        $stmt = $pdo->prepare($inst_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':addr', $room_no);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        if ($pdo->lastInsertId()) {
            echo "Insert Successful";
        }
        $pdo = null;
    } catch (PDOException $e) {
        echo "Error($e->getMessage())";
        return false;
    }
}


function select_data()
{
    $pdo = connect_to_db_pdo();
    try {
        $select_query = "select id , name, room, email, profile_image,role from users";
        $stmt = $pdo->prepare($select_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    } catch (Exception $e) {
        echo "Error($e->getMessage())";
        return false;
    }
}






function select_User($id)
{
    try {
        $pdo = connect_to_db_pdo();
        $select_query = "select * from users where id = :id";
        $stmt = $pdo->prepare($select_query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    } catch (PDOException $e) {
        echo "Error($e->getMessage())";
    }
}

function update_User($id, $name, $room_no, $email)
{
    try {
        $pdo = connect_to_db_pdo();
        $updateQuery = "UPDATE users SET name = :name, room_no = :room_no, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':room_no', $room_no);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function delete_data($id)
{
    try {
        $pdo = connect_to_db_pdo();
        $delete_query = "delete from users where id = :id";
        $stmt = $pdo->prepare($delete_query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            echo "Delete Successful";
        } else {
            echo "Error($e->getMessage())";
        }
        $pdo = null;
    } catch (PDOException $e) {
        echo "Error($e->getMessage())";
    }
}
