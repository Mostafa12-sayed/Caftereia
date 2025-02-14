
<?php



const DB_USER = 'root';
const DB_PASSWORD = 'root';
const DB_PORT = 3306;

function connect_to_db_pdo()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=cafeteria_db", DB_USER, DB_PASSWORD);
        return $pdo;
    } catch (PDOException $e) {
        echo "displayError($e)";
    }
}
