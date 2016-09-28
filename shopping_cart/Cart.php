<?php
include_once('Database.php');

class Cart
{
    private $database;
    private $cartName;
    private $products;
    private $totalAmount;
    private $totalDiscount;
    private $totalTax;
    private $grandTotal;
    private $amountWithTax;
    private $amountWithDiscount;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->totalAmount = 0;
        $this->totalDiscount  = 0;
        $this->totalTax = 0;
        $this->products = array();
        $this->grandTotal = 0;
        $this->amountWithTax = 0;
        $this->amountWithDiscount = 0;
        $this->cartName ='no cart found';
    }
    public function deleteCart($productId)
    {
        return $this->database->deleteFromCart($productId);
    }
    public function addProductToCart($cart_name, $product_name )
    {
        $product_id = $this->database->selectFromProducts($product_name);
        return $this->database->addToCart($cart_name,1,$product_id['id']);

    }
    public function updateCart($cartId,$columnToUpdate,$newValue)
    {
        return $this->database->updateCart($cartId,$columnToUpdate,$newValue);
    }
    public function showCart()
    {
        $productObject = new Products();
        $categoryObject = new Category();
        $result = $this->database->selectFromCart();
        foreach($result as $cartKey=> $cartValue)
        {
            $this->cartName = $cartValue['cart_name'];
            if($cartValue['order_id']=='1')
            {
                $productsInCart = $productObject->getProduct($cartValue['product_id']);
                array_push($this->products,$productsInCart);
                $price = floatval($productsInCart['price']);
                $this->totalAmount = $this->totalAmount + ($price);
                $this->discountAmount = $price * (floatval($productsInCart['discount']))/100;
                $this->totalDiscount = $this->totalDiscount + $this->discountAmount;
                $categoryOfProduct = $categoryObject->getCategory($productsInCart['category_id']);
                $tax = $price * (floatval($categoryOfProduct['tax']))/100;
                $this->totalTax = $this->totalTax+$tax;
            }
        }
        $this->amountWithDiscount = $this->totalAmount-$this->totalDiscount;
        $this->amountWithTax = $this->totalAmount+$this->totalTax;
        $arrayCart = array("cart_name" => $this->cartName, "Products" => $this->products, "Total" => $this->totalAmount, "Total Discount" => $this->totalDiscount, "Total with Discount" =>$this->amountWithDiscount,"total_tax"=>$this->totalTax,"total with tax"=>$this->amountWithTax,"grand total"=>$this->totalAmount+$this->totalTax-$this->totalDiscount);
        return $arrayCart;
    }
    public function selectCartWithName($cartName)
    {

    }
}