<?php 


function user_previous_orders_filtered($id,$start_date,$end_date,$offset,$limit)
{
    $db_object = connect_to_database();
    try {
        $query =
            "SELECT 
            orders.id,
            users.name AS user_name,
            orders.date,
            GROUP_CONCAT(
            CONCAT(products.name, ' (x', order_items.quantity, ')',' - $', FORMAT(products.price, 2),' = $', FORMAT(products.price * order_items.quantity, 2))
            ORDER BY products.name) AS products_ordered,
            orders.room,
            orders.status,
            orders.total_price,
            orders.notes,
            GROUP_CONCAT(products.image ORDER BY products.name) AS product_images 
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        JOIN products ON products.id = order_items.product_id
        JOIN users ON users.id = orders.user_id
        WHERE users.id = (:id) 
        AND orders.date BETWEEN (:start_date) AND (:end_date)
        GROUP BY orders.id, users.name, orders.date, orders.room, orders.status, orders.total_price, orders.notes
        LIMIT $limit OFFSET $offset;";
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


function count_selected_rows($id,$start_date,$end_date){
    $db_object=connect_to_database();
    try{
        $query="SELECT COUNT(*) as rows_count FROM orders join users on users.id = orders.user_id WHERE users.id = (:id) AND orders.date BETWEEN (:start_date) AND (:end_date);";
        $stmt=$db_object->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}



function all_products($limit,$offset){
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
        JOIN categories ON products.category_id = categories.id
        GROUP BY products.id, categories.name, categories.id
        LIMIT $limit OFFSET $offset;";
        $stmt=$db_object->prepare($query);
        $stmt->execute();
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}

function count_all_products(){
    try{
    $db_object=connect_to_database();
    $query="SELECT COUNT(id) as rows_count FROM products;";
    $stmt=$db_object->prepare($query);
    $stmt->execute();
    $res=$stmt->fetch(PDO::FETCH_ASSOC);
    return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


function delete_product($id, $image){
    try{
    $db_object=connect_to_database();
    $query="DELETE FROM products WHERE id = (:id);";
    $stmt=$db_object->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    unlink("../../assets/images/products/".$image);
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


function edit_product($id, $name, $price, $category, $image,$status){
    try{
        $db_object=connect_to_database();
        $query="UPDATE products SET name = :name, price = :price, category_id = :category_id, image = :image, status = :status WHERE id = :id;";
        $stmt=$db_object->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);

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



function delete_order($id){
    try{
    $db_object=connect_to_database();
    $query="DELETE FROM orders WHERE id = (:id);
    DELETE FROM order_items WHERE order_id = (:id);";
    $stmt=$db_object->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}



function ordered_products_by_id($id){
    try{
    $db_object=connect_to_database();
    $query="SELECT products.name, order_items.quantity, products.price as product_price FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = :id;";
    $stmt=$db_object->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}



function add_category($name){
    try{
        $db_object=connect_to_database();
        $query="INSERT INTO categories (name) VALUES (:name);";
        $stmt=$db_object->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();
    }
}


?>