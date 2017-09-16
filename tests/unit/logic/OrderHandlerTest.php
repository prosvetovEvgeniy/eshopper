<?php
namespace logic;

use app\logic\busket\CartItemsHandler;
use app\logic\order\OrderHandler;
use app\models\CartItems;
use app\models\Order;
use app\models\OrderItems;
use Yii;

class OrderHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $user;
    protected $cart;

    protected function _before()
    {
        $this->user = getUser();
        $this->cart = getCart();
    }

    protected function _after()
    {
        $this->user = null;
        $this->cart = null;
    }

    // tests
    public function testSaveOrder()
    {
        $randProduct = getRandProduct();

        Yii::createObject(CartItemsHandler::class, [$this->cart, $randProduct, 1])->saveItem();

        $items = CartItems::findAll(['cart_id' => $this->cart->id]);

        Yii::createObject(OrderHandler::class)->saveOrder($items, $this->user->email);

        $order = Order::findOne(['user_id' =>  $this->user->id]);

        $this->tester->seeRecord('app\models\Order', ['user_id' => $this->user->id]);
        $this->tester->seeRecord('app\models\OrderItems', ['order_id' => $order->id]);
    }
}