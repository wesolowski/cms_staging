<?php


class TryDeleteProductTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester $tester
     */
    protected UnitTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        parent::_after();
        unset($_SERVER['REQUEST_METHOD']);
    }

    // tests
    public function testDeletingAProductAndDisplayChanges(): void
    {
        $_SERVER['REQUEST_METHOD'] = '';
        $_GET = [
                'cl' => 'product',
                'page' => 'list',
                'admin' => 'true',
        ];
        $this->tester->arrange();
        $this->tester->logIntoBackend();
        $productList = (array)$this->tester->getSmartyParams('productlist');
        $tmp = (array)$this->tester->getProductList();
        $id = end($tmp)->getProductId();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_GET = [
                'cl' => 'product',
                'page' => 'list',
                'admin' => 'true',
        ];
        $_POST = [
                'delete' => ''.$id,
                'newpagedescription' => 'A plain shirt',
                'newpagename' => 'T-Shirt',
        ];
        $this->tester->arrange();
        $this->tester->logIntoBackend();
        //$productList = (array)$this->tester->getSmartyParams('productlist');
        $secondProductList = (array)$this->tester->exchangeDtoToSmartyParam(
            $this->tester->getProductList(),
            'productlist'
        );
        $this->assertNotEquals($productList, $secondProductList);
    }
}