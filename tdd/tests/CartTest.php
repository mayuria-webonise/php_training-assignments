<?php
class CartTest extends PHPUnit_Framework_TestCase {
    protected static $cart;

    public static function setUpBeforeClass()
    {
        self:: $cart = new Cart();
    }
    public static function tearDownAfterClass()
    {
        self::$cart = null;
    }
    function testCartInitialization()
    {
        $this->assertInstanceOf('Cart',self::$cart);
    }
    /**
     * @dataProvider deleteCartProvider
     */
    function testReturnDeleteCart($expected,$id)
    {
        $this->assertEquals($expected,self::$cart->deleteCart($id));
    }
    public function deleteCartProvider()
    {
        return array(
            array(true,1),
            array(false,-2),
            array(false,'a')
        );
    }
    /**
     * @dataProvider updateCartProvider
     */
    function testReturnUpdateCart($id,$columnName,$value,$type)
    {
        if($type == false)
        {
            $this->assertFalse(self::$cart->updateCart($id,$columnName,$value));
        }
        else
        {
            $this->assertInternalType($type,self::$cart->updateCart($id,$columnName,$value));
        }
    }
    public function updateCartProvider()
    {
        return array(
            array(1,'cart_name','home goodies','array'),
            array(1,'Cart','test',false)
        );
    }
    function testSelectFromCartIsEmpty()
    {
        $database = Database::connect();
        $this->assertEmpty($database->selectFromCart());
        return $database->selectFromCart();
    }
    /**
     * @depends testSelectFromCartIsEmpty
     */
    function testShowCart($result)
    {
        if(empty($result))
        {
            $this->assertFalse(self::$cart->showCart());
        }
        else
        {
            $this->assertInternalType('array', self::$cart->showCart());
        }
    }
}
