<?php
require("/home/webonise/Desktop/tdd/vendor/autoload.php");


class ProductsTest extends PHPUnit_Framework_TestCase {

    protected static $product;
    public static function setUpBeforeClass()
    {
        self:: $product = new Products();
    }
    public static function tearDownAfterClass()
    {
        self::$product = null;
    }
    /**
     * @dataProvider productProvider
     */
    public function testReturnBooleanAddProducts($name,$description,$price,$discount,$category,$expected)
    {
        $this->assertEquals($expected,self::$product->addProduct($name,$description,$price,$discount,$category));
    }
    public function productProvider()
    {
        return array(
            array('mouse','microsoft mouse',100,10,'electronics',true),
            array('table','wooden table',100,10,'home',true)
        );
    }
    function testProductInitialization()
    {
        $this->assertInstanceOf('Products',self::$product);
    }
    /**
     * @dataProvider updateProductProvider
     */
    function testReturnUpdateProducts($id,$columnName,$value,$type)
    {
        if(false == $type)
        {
            $this->assertFalse(self::$product->updateProduct($id,$columnName,$value));
        }
        else
        {
            $this->assertInternalType($type,self::$product->updateProduct($id,$columnName,$value));
        }

    }
    public function updateProductProvider()
    {
        return array(
            array(1,'product_name','test','array'),
            array(1,'product','test',false)
        );
    }
    /**
     * @dataProvider deleteProductProvider
     */
    function testReturnDeleteProducts($expected,$id)
    {
        $this->assertEquals($expected,self::$product->deleteProduct($id));
    }
    public function deleteProductProvider()
    {
        return array(
            array(true,1),
            array(false,-2),
            array(false,'a')

        );
    }
    function testReturnListProducts()
    {
        $this->assertInternalType('array',self::$product->listProducts());
    }
}
