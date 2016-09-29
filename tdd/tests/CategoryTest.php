<?php
require("/home/webonise/Desktop/tdd/vendor/autoload.php");
include_once('/home/webonise/Desktop/tdd/src/category.php');

class CategoryTest extends PHPUnit_Framework_TestCase {

    protected static $category;
    public static function setUpBeforeClass()
    {
        self:: $category = new Category();
    }
    public static function tearDownAfterClass()
    {
        self::$category = null;
    }
    /**
     * @dataProvider categoryProvider
     */
    public function testReturnBooleanAddCategories($name,$description,$tax,$expected)
    {
        $this->assertEquals($expected,self::$category->addCategory($name,$description,$tax));
    }
    public function categoryProvider()
    {
        return array(
            array('electronics','electronics appliances',10,true),
            array('home','home',20,true)
        );
    }
    function testCategoryInitialization()
    {
        $this->assertInstanceOf('Category',self::$category);
    }
    /**
     * @dataProvider updateCategoryProvider
     */
    function testReturnUpdateCategories($id,$columnName,$value,$type)
    {
        if($type == false)
        {
            $this->assertFalse(self::$category->updateCategory($id,$columnName,$value));
        }
        else
        {
            $this->assertInternalType($type,self::$category->updateCategory($id,$columnName,$value));
        }
    }
    public function updateCategoryProvider()
    {
        return array(
            array(1,'category_name','home goodies','array'),
            array(1,'category','test',false)
        );
    }
    /**
     * @dataProvider deleteCategoryProvider
     */
    function testReturnDeleteCategories($expected,$id)
    {
        $this->assertEquals($expected,self::$category->deleteCategory($id));
    }
    public function deleteCategoryProvider()
    {
        return array(
            array(true,11),
            array(false,-2),
            array(false,'a')

        );
    }
    function testReturnListCategories()
    {
        $this->assertInternalType('array',self::$category->listCategories());
    }
}
