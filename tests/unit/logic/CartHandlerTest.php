<?php
namespace logic;


use app\logic\busket\CartHandler;
use app\models\Cart;
use app\models\CartItems;
use app\models\User;
use app\models\Product;
use Yii;

class CartHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $uuid;

    protected function _before()
    {
        $this->uuid = '537942e5-68a2-e785-235a-3ce24affcf45';
    }

    protected function _after()
    {
        $this->uuid = null;
    }

    // tests
    public function testCreateCart()
    {
        $cartHandler = new CartHandler($this->uuid);
        $cartHandler->createCart();

        $this->tester->seeRecord('app\models\Cart', ['id' => $this->uuid]);
    }

    public function testAttachUserToCart(){
        $user = getUser();

        Yii::createObject(CartHandler::class, [$this->uuid])->attachUserToCart($user->email);

        $this->tester->seeRecord('app\models\Cart', ['user_id' => $user->id]);
    }

    public function testClearCart(){
        $cartHandler = new CartHandler($this->uuid);
        $cartHandler->createCart();

        $products = Product::find()->all();

        $randProduct = $products[mt_rand(0,count($products)-1)];

        $cartItem = new CartItems();
        $cartItem->cart_id = $cartHandler->getCartId();
        $cartItem->product_id = $randProduct->id;
        $cartItem->amount = 1;
        $cartItem->save();

        $cartHandler->clearCart();

        $this->tester->dontSeeRecord('app\models\CartItems', ['cart_id' => $cartHandler->getCartId()]);
    }

    public function testAddUserId(){
        $user = getUser();

        $cartHandler = new CartHandler($this->uuid);
        $cartHandler->createCart();
        $cartHandler->addUserId($user->email);

        $this->tester->seeRecord('app\models\Cart', ['user_id' => $user->id]);
    }

    public function testGetCartId(){
        $cartHandler = new CartHandler($this->uuid);
        $cartHandler->createCart();
        $this->tester->assertEquals($this->uuid, $cartHandler->getCartId());
    }

    public function testGetCart(){
        $cartHandler = new CartHandler($this->uuid);
        $cartHandler->createCart();

        $this->tester->assertInstanceOf(Cart::class, $cartHandler->getCart());
    }
}