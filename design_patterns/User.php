<?php
include_once('Database.php');
include_once('UserInterface.php');
class User implements UserInterface
{
    private $database;
    function __construct()
    {
        $this->database = Database::connect();
    }
    public function listAllProducts()
    {
        return $this->database->listAllProducts();
    }
    public function selectFromProducts($product_name)
    {
        return $this->database->selectFromProducts($product_name);
    }
}