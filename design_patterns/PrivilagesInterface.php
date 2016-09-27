<?php
/**
 * Created by PhpStorm.
 * User: webonise
 * Date: 27/9/16
 * Time: 10:45 AM
 */

interface PrivilegesInterface {

    public function listAllProducts();
    public function selectFromProducts($product_name);
}