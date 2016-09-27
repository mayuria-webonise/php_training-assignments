<?php
include_once('PrivilagesInterface.php');
interface AdminInterface extends PrivilegesInterface
{
    public function addProducts($productName,$productPrice);
    public function updateProductPrice();
    public function updateUser();
}