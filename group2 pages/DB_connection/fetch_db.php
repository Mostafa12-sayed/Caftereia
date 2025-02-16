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
        $query="SELECT 
            products.id as id,
            products.name,
            products.price,
            products.status,
            products.image,
            categories.name as category,
            categories.id as category_id
        FROM products
        JOIN categories ON products.category_id = categories.id;";
        $stmt=$db_object->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}




function delete_product($id){
    try{
    $db_object=connect_to_database();
    $query="DELETE FROM products WHERE id = (:id);";
    $stmt=$db_object->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


function all_categories(){
    try{
    $db_object=connect_to_database();
    $query="select * from categories;";
    $stmt=$db_object->prepare($query);
    $stmt->execute();
    $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }

}

function add_product($name,$price,$category,$image){
    try{
        $db_object=connect_to_database();
        $query="INSERT INTO products (name, price, category_id, image) VALUES (:name, :price, :category_id, :image);";
        $stmt=$db_object->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


function edit_product($id, $name, $price, $category, $image){
    try{
        $db_object=connect_to_database();
        $query="UPDATE products SET name = :name, price = :price, category_id = :category_id, image = :image WHERE id = :id;";
        $stmt=$db_object->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


function fetch_single_product($id){
    try{
    $db_object=connect_to_database();
    $squery="select 
            products.name,
            products.price,
            products.status,
            products.image,
            categories.name as category,
            categories.id as category_id
        FROM products
        JOIN categories ON products.category_id = categories.id
        where products.id=:id;";
        $stmt=$db_object->prepare($squery);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
    }catch (PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}







?>