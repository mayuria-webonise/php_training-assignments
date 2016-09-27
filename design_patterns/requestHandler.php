<?php
include_once('User.php');
include_once('Admin.php');
include_once('upload.php');
include_once('CurrencyRupees.php');
include_once('CurrencyPound.php');

session_start();

if(!strcmp($_SESSION['role'],'admin'))
{
    $user = new Admin();
}
else
{
    $user = new User();
}
if (isset($_FILES['image1'])) {
    foreach ($_FILES as $imageKey) {
        if (strpos($imageKey['type'], 'image') !== false) {

            $uploadImages = new UploadProductImages();
            $targetFile = $uploadImages->imageUpload($imageKey);
        }
    }
}
if(isset($_POST['add_product'])) {

    echo "call add";
    $status = $user->addProducts($_POST['product_name'], $_POST['price']);
    if ($status) {
        echo "insert product successful";
    }
}
if(isset($_POST['search_product']))
{
    $productDetails = $user->selectFromProducts($_POST['product_name']);
    if(empty($productDetails))
    {
        echo "no products found";
    }
    else {
        if(isset($_POST['in_pound']))
        {
            $currencyConvert = new CurrencyPound();
            echo "price in Pounds ".$currencyConvert->convert($productDetails['price'])."<br>";
        }
        if(isset($_POST['in_rupees']))
        {
            $currencyConvert = new CurrencyRupees();
            echo "price in Rupees ".$currencyConvert->convert($productDetails['price']);
        }
        echo '<pre>', print_r($productDetails);
    }
}
if(isset($_POST['list_products']))
{
    $productList = $user->listAllProducts();
    if(empty($productList))
    {
        echo "no products found";
    }
    else {

        echo '<pre>', print_r($productList);
    }
}
?>