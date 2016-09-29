<?php
/**
 * Created by PhpStorm.
 * User: webonise
 * Date: 28/9/16
 * Time: 5:16 PM
 */
use PHPUnit\Framework\TestCase;

class Test extends TestCase {

    function test()
    {
        $product = new Products();

        $this->assertEquals(true,$product->addProduct('name','description',10,10,'category'));
    }

}
