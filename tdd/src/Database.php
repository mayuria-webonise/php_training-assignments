<?php
class Database
{
    private $databaseDriver;
    private static $instance = null;
    private function __construct()
    {
        try {
            $this->databaseDriver = new PDO("mysql:host=localhost;dbname=shopping_cart", "root", "mayuri123#");
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
    function listAllProducts()
    {
        $selectStatement = $this->databaseDriver->prepare("select * from products;");
        $selectStatement->execute();
        $results = $selectStatement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    function selectFromProducts($productId)
    {
        $selectStatement = $this->databaseDriver->prepare("select * from products  where id = :product_id;");
        $selectStatement->bindParam(":product_id", $productId);
        $selectStatement->execute();
        $results = $selectStatement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }
    function addProduct($product_name,$description,$price,$discount,$category_id)
    {
        $statementFile = $this->databaseDriver->prepare("INSERT INTO products (product_name,description,price,discount,category_id)VALUES (:product_name,:description,:price,:discount,:category_id);");
        $statementFile->bindParam(":product_name", $product_name);
        $statementFile->bindParam(":description", $description);
        $statementFile->bindParam(":price", $price);
        $statementFile->bindParam(":discount", $discount);
        $statementFile->bindParam(":category_id", $category_id);
        if ($statementFile->execute()) {
            return true;
        } else {
            return true;
        }
    }
    function updateProduct($productId,$columnToUpdate,$newColumnValue)
    {
        $statementProduct = $this->databaseDriver->prepare("UPDATE shopping_cart.products SET ".$columnToUpdate." = :new_column_value WHERE id = :product_id;");
        $statementProduct->bindParam(":new_column_value", $newColumnValue);
        $statementProduct->bindParam(":product_id", $productId);
        if ($statementProduct->execute()) {
            return $this->listAllProducts();
        } else {
            return false;
        }
    }
    function deleteProduct($productId)
    {
        if($productId<0)
        {
            return false;
        }
        if(!is_int($productId))
        {
            return false;
        }
        $statementProduct = $this->databaseDriver->prepare("delete from products where id=:product_id;");
        $statementProduct->bindParam(":product_id", $productId);
        if ($statementProduct->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function addCategory($categoryName,$description,$tax)
    {
        $statementCategory = $this->databaseDriver->prepare("INSERT INTO category (category_name,category_description,tax) VALUES (:category_name,:category_description,:tax);");
        $statementCategory->bindParam(":category_name", $categoryName);
        $statementCategory->bindParam(":category_description", $description);
        $statementCategory->bindParam(":tax", $tax);
        if ($statementCategory->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function deleteCategory($category_id)
    {
        if($category_id<0)
        {
            return false;
        }
        if(!is_int($category_id))
        {
            return false;
        }
        $statementCategory = $this->databaseDriver->prepare("delete from category where idcategory= :category_id;");
        $statementCategory->bindParam(":category_id", $category_id);
        if ($statementCategory->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function updateCategory($category_id,$columnToUpdate,$newColumnValue)
    {
        $statementCategory = $this->databaseDriver->prepare("UPDATE shopping_cart.category SET ".$columnToUpdate." = :new_column_value WHERE idcategory = :category_id;");
        $statementCategory->bindParam(":new_column_value", $newColumnValue);
        $statementCategory->bindParam(":category_id", $category_id);
        if ($statementCategory->execute()) {
            return $this->listCategories();
        } else {
            return false;
        }
    }
    function getCategory($categoryId)
    {
        $statementCategory = $this->databaseDriver->prepare("select tax from category where idcategory = :category_id;");
        $statementCategory->bindParam(":category_id",$categoryId);
        $statementCategory->execute();
        $results = $statementCategory->fetch(PDO::FETCH_ASSOC);
        return $results;
    }
    function listCategories()
    {
        $statementCategory = $this->databaseDriver->prepare("select * from category;");
        $statementCategory->execute();
        $results = $statementCategory->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    function addToCart($cartName,$orderId,$productId)
    {
        $statementCart = $this->databaseDriver->prepare("INSERT INTO cart (cart_name,order_id,product_id) VALUES (:cart_name,:order_id,:product_id);");
        $statementCart->bindParam(":cart_name", $cartName);
        $statementCart->bindParam(":order_id", $orderId);
        $statementCart->bindParam(":product_id", $productId);
        if ($statementCart->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function deleteFromCart($productId)
    {
        if($productId<0)
        {
            return false;
        }
        if(!is_int($productId))
        {
            return false;
        }
        $statementCart = $this->databaseDriver->prepare("delete from cart where product_id=:product_id;");
        $statementCart->bindParam(":product_id", $productId);
        if ($statementCart->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function selectFromCart()
    {
        $statementCart = $this->databaseDriver->prepare("select * from cart;");
        $statementCart->execute();
        $results = $statementCart->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    function updateCart($cartId,$columnToUpdate,$newColumnValue)
    {
        $statementCart = $this->databaseDriver->prepare("UPDATE shopping_cart.cart SET ".$columnToUpdate." = :new_column_value WHERE order_id = :cart_id;");
        $statementCart->bindParam(":new_column_value", $newColumnValue);
        $statementCart->bindParam(":cart_id", $cartId);
        if ($statementCart->execute()) {
            return $this->selectFromCart();
        } else {
            return false;
        }
    }



}