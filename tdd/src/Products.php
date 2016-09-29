<?php
include_once('Database.php');
class Products
{
    private $database;
    public function __construct()
    {
        $this->database = Database::connect();
    }
    public function addProduct($name,$description, $price, $discount,$category_name)
    {
        $category_id  = $this->database->getCategory($category_name);
        return $this->database->addProduct($name,$description, $price, $discount,$category_id['idcategory']);
    }
    public function updateProduct($product_id,$columnToUpdate,$newColumn)
    {
        return $this->database->updateProduct($product_id,$columnToUpdate,$newColumn);
    }
    public function deleteProduct($productId)
    {
        return $this->database->deleteProduct($productId);
    }
    public function listProducts()
    {
        return $this->database->listAllProducts();
    }
    public function getProduct($productId)
    {
        return $this->database->selectFromProducts($productId);
    }

}