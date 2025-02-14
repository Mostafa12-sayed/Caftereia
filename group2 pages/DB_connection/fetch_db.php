<?php 


function user_previous_orders()
{
    $db_object = connect_to_database();
    try {
        $query =
            "SELECT 
            users.name AS user_name,
            orders.date,
            GROUP_CONCAT(CONCAT(products.name, ' (x', order_items.quantity, ')')) AS products_ordered,
            orders.room,
            orders.status,
            orders.total_price,
            orders.notes,
            products.image
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN products ON products.id = order_items.product_id
        JOIN users ON users.id = orders.user_id
        WHERE users.id = 2
        GROUP BY orders.id, users.name, orders.date, orders.room, orders.status, orders.total_price, products.image;";
        $stmt = $db_object->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}




function user_previous_orders_filtered($id,$start_date,$end_date)
{
    $db_object = connect_to_database();
    try {
        $query =
            "SELECT 
            users.name AS user_name,
            orders.date,
            GROUP_CONCAT(CONCAT(products.name, ' (x', order_items.quantity, ')')) AS products_ordered,
            orders.room,
            orders.status,
            orders.total_price,
            orders.notes,
            products.image
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN products ON products.id = order_items.product_id
        JOIN users ON users.id = orders.user_id
        WHERE users.id = (:id) 
        and orders.date BETWEEN (:start_date) and (:end_date)
        GROUP BY orders.id, users.name, orders.date, orders.room, orders.status, orders.total_price, products.image;";
        $stmt = $db_object->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}





function all_products(){
    $db_object=connect_to_database();
    try{
        $query="select name,image 
        from products where id=2;";
        $stmt=$db_object->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}



















?>