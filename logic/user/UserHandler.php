<?php

namespace app\logic\user;

use app\models\User;
use app\models\CartItems;

use Yii;

class UserHandler
{
    protected $email;

    public function __construct($email = null)
    {
        $this->email = $email;
    }

    //отпраляем сообщение пользователю на email (локально)
    public function sendEmail($items, $cartId, $password = null){

        $totalAmount = CartItems::getTotalAmount($cartId);
        $totalPrice = CartItems::getTotalPrice($cartId);

        Yii::$app->mailer->compose('order',['items' => $items, 'password' => $password, 'totalAmount' => $totalAmount, 'totalPrice' => $totalPrice])
            ->setFrom(['test@yandex.ru' => 'eshopper'])
            ->setTo($this->email)
            ->setSubject('Заказ')->send();
    }
    public function addDataToUser(){
        //$user = User::findOne(['email' => $this->email]);

        //$user->phone = $this->phone;
        //$user->address = $this->address;

        return true;
    }
    public function getUserId(){
        $user = User::findOne(['email' => $this->email]);
        return $user->id;
    }
}