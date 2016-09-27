<?php
class Database
{
    private $databaseDriver;
    private static $instance=null;
    private function __construct()
    {
        try {
            $this->databaseDriver = new PDO("mysql:host=localhost;dbname=e_commerce", "root", "mayuri123#");
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
    public static function connect(){
        if(self::$instance == null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
    function selectFromUsers()
    {
        $role = "user";
        $selectStatement = $this->databaseDriver->prepare("select idusers from users  where role = :role;");
        $selectStatement->bindParam(":role",$role);
        $selectStatement->execute();
        $results = $selectStatement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    function listAllProducts()
    {
        $selectStatement = $this->databaseDriver->prepare("select * from products;");
        $selectStatement->execute();
        $results = $selectStatement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    function selectFromProducts($product_name)
    {
        $selectStatement = $this->databaseDriver->prepare("select * from products  where product_name = :product_name;");
        $selectStatement->bindParam(":product_name", $product_name);
        $selectStatement->execute();
        $results = $selectStatement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    function updateUser()
    {
        $role = 'user';
        $password = 'user';
        $statementPrepared = $this->databaseDriver->prepare("INSERT INTO users (user_name, email,password,role) VALUES (:username,:email,:password,:role)");
        $statementPrepared->bindParam(":username", $_POST['name']);
        $statementPrepared->bindParam(":email", $_POST['email']);
        $statementPrepared->bindParam(":password", $password);
        $statementPrepared->bindParam(":role", $role);

        if ($statementPrepared->execute()) {
            echo "insert success";
            return true;
        } else {
            echo "fail";
            return false;
        }
    }

    function updateProductTable($product_name,$price)
    {
        $color_id = 1;
        echo "insert".$product_name;

        $statementFile = $this->databaseDriver->prepare("INSERT INTO products (product_name,color_id,price)VALUES (:product_name,:color_id,:price);");
        $statementFile->bindParam(":product_name", $product_name);
        $statementFile->bindParam(":color_id", $color_id);
        $statementFile->bindParam(":price", $price);
        if ($statementFile->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function authenticateUser($email,$password){

        $statementPrepared=$this->databaseDriver->prepare("select * from users where email = :email and password = :password");
        $statementPrepared->bindParam(':email',$email);
        $statementPrepared->bindParam(':password',$password);
        $statementPrepared->execute();
        $result = $statementPrepared->fetchAll(PDO::FETCH_ASSOC);
        if(empty($result))
        {
            return false;
        }
        else {
            foreach ($result as $row) {
                $_SESSION['user_id'] = $row['idusers'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['role'] = $row['role'];
            }
        }
        return true;
    }


}