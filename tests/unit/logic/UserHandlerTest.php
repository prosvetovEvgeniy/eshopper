<?php
namespace logic;

use app\logic\user\UserHandler;
use app\models\User;

class UserHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->userHandler = new UserHandler();
    }

    protected function _after()
    {
        $this->userHandler = null;
    }

    // tests
    public function testSignUp()
    {
        $this->userHandler->signUp('test', 'test@mail.ru', '89131841102', 'test_address', 'test');
        $this->tester->seeRecord('app\models\User', ['email' => 'test@mail.ru']);
    }
}