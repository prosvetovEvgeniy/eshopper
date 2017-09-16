<?php
namespace logic;


use app\logic\busket\CartHandler;
use app\logic\busket\CartItemsHandler;
use app\models\Product;

class CartItemsHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $cartHandler;

    protected function _before()
    {
        $this->cart = getCart();
    }

    protected function _after()
    {
        $this->cart = null;
    }

    // tests
    public function testSaveItem()
    {
        $randProduct = getRandProduct();

        $cartItemsHandler = new CartItemsHandler($this->cart, $randProduct, 1);

        $cartItemsHandler->saveItem();
        $this->tester->seeRecord('app\models\CartItems', ['product_id' => $randProduct->id, 'amount' => 1]);

        $cartItemsHandler->saveItem();
        $this->tester->seeRecord('app\models\CartItems', ['product_id' => $randProduct->id, 'amount' => 2]);
    }

    public function testRemoveItem()
    {
        $randProduct = getRandProduct();

        $cartItemsHandler = new CartItemsHandler($this->cart, $randProduct, 2);
        $cartItemsHandler->saveItem();

        $cartItemsHandler->removeItem();
        $this->tester->seeRecord('app\models\CartItems', ['product_id' => $randProduct->id, 'amount' => 1]);

        $cartItemsHandler->removeItem();
        $this->tester->dontSeeRecord('app\models\CartItems', ['product_id' => $randProduct->id]);
    }

}