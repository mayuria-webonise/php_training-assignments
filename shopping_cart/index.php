<?php
include_once('Products.php');
include_once('Category.php');
include_once('Cart.php');
define("PRODUCT_REQUEST","1");
define("CART_REQUEST","2");
define("CATEGORY_REQUEST","3");

if($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    if($_GET['request'] == CART_REQUEST)
    {
        $cartObject = new Cart();
        echo $cartObject->deleteCart($_GET['Id']);
    }
    elseif($_GET['request'] == PRODUCT_REQUEST)
    {
        $productsObject = new products();
        if(!$productsObject->deleteProduct($_GET['Id']))
        {
            echo "can not delete, product is referred in other table";
        }
    }
    elseif($_GET['request'] == CATEGORY_REQUEST)
    {
        $categoryObject = new Category();
        if(!$categoryObject->deleteCategory($_GET['Id']))
        {
            echo "can not delete, category is referred in other table";
        }
    }
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if(isset($_GET['products']))
    {
        header('Content-Type: application/json');
        $productsObject = new Products();
        $result = $productsObject->listProducts();
        $result = json_encode($result);
        echo $result;
    }
    if(isset($_GET['cart']))
    {
        header('Content-Type: application/json');
        $cartObject = new Cart();
        $result = $cartObject->showCart();
        $result = json_encode($result);
        echo $result;
    }
    if(isset($_GET['category']))
    {
        header('Content-Type: application/json');
        $categoryObject = new Category();
        $result = $categoryObject->listCategories();
        $result = json_encode($result);
        echo $result;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_GET['products']))
    {
        $productsObject = new Products();
        $result = $productsObject->addProduct($_POST['name'],$_POST['description'],$_POST['price'],$_POST['discount'],$_POST['category_name']);
        $result = json_encode($result);
        echo $result;
    }
    if(isset($_GET['cart']))
    {
        $cartObject = new Cart();
        echo $cartObject->addProductToCart($_POST['cart_name'],$_POST['product_name']);
    }
    if(isset($_GET['category']))
    {
        $categoryObject = new Category();
        echo $_POST['category_name']."hello";
        echo $categoryObject->addCategory($_POST['category_name'],$_POST['category_description'],$_POST['tax']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    if($_GET['request'] == PRODUCT_REQUEST)
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $productsObject = new Products();
        $result = $productsObject->UpdateProduct($_GET['Id'],$post_vars['column'],$post_vars['new_value']);
        $result = json_encode($result);
        echo $result;
    }
    if($_GET['request'] == CART_REQUEST)
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $cartObject = new Cart();
        $result = $cartObject->updateCart($_GET['Id'],$post_vars['column'],$post_vars['new_value']);
        $result = json_encode($result);
        echo $result;

    }
    if($_GET['request'] == CATEGORY_REQUEST)
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $categoryObject = new Category();
        $result = $categoryObject->updateCategory($_GET['Id'],$post_vars['column'],$post_vars['new_value']);
        $result = json_encode($result);
        echo $result;
    }
}