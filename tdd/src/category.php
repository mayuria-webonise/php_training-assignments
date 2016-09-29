<?php

include_once('Database.php');

class Category
{
    private $database;
    public function __construct()
    {
        $this->database = Database::connect();
    }
    public function addCategory($categoryName,$categoryDescription,$tax)
    {
        return $this->database->addCategory($categoryName,$categoryDescription,$tax);
    }
    public  function updateCategory($categoryId,$columnToUpdate,$newValue)
    {
        return $this->database->updateCategory($categoryId,$columnToUpdate,$newValue);
    }
    public  function deleteCategory($categoryId)
    {
        return $this->database->deleteCategory($categoryId);
    }
    public  function listCategories()
    {
        return $this->database->listCategories();
    }
    public function getCategory($categoryId)
    {
        return $this->database->getCategory($categoryId);
    }
}