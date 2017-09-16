<?php
namespace logic;

use app\logic\user\UserHandler;
use app\models\CartItems;
use Yii;

class UserHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        $this->userHandler = null;
    }

    // tests
    public function testSignUp()
    {
        $userHandler = new UserHandler();
        $userHandler->signUp('test', 'test@mail.ru', 'test_phone', 'test_address', 'test');
        $this->tester->seeRecord('app\models\User', ['email' => 'test@mail.ru']);
    }

    public function testQuickSignUp(){
        $userHandler = new UserHandler();
        $userHandler->quickSignUp('test', 'test@mail.ru', 'test');
        $this->tester->seeRecord('app\models\User', ['email' => 'test@mail.ru']);
    }

    public function testSendEmail(){
        $cartId = '537942e5-68a2-e785-235a-3ce24affcf45';
        $items = CartItems::find()->where(['cart_id' => $cartId])->all();
        Yii::createObject(UserHandler::class)->sendEmail($items, $cartId, 'test@mail.ru');
    }

    /*public function testAddDataToUser(){
        $userHandler = new UserHandler();
        $userHandler->quickSignUp('test', 'test@mail.ru', 'test');
        $user = User::findOne(['email' => 'test@mail.ru']);
        $userHandler->addDataToUser($user, 'test_phone', 'test_address');
        $this->tester->seeRecord('app\models\User', ['email' => 'test@mail.ru', 'phone' => 'test_phone', 'address' => 'test_address']);
    }*/
}