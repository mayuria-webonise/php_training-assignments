<?php
include_once('AdminInterface.php');
class Admin implements AdminInterface{

    public $database;
    function __construct()
    {
        $this->database = Database::connect();
    }
    function updateProductPrice()
    {
        return true;
    }
    function updateUser()
    {
        $this->database->updateUser();
    }
    function addProducts($productName,$productPrice)
    {
       return $this->database->updateProductTable($productName,$productPrice);
    }
    public function listAllProducts()
    {
        $this->database->listAllProducts();
    }
    public function selectFromProducts($product_name)
    {
        return $this->database->selectFromProducts($product_name);
    }

}