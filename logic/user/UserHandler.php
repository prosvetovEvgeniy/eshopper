<?php

namespace app\logic\user;

use app\models\User;
use app\models\CartItems;

use Yii;

class UserHandler
{
    //отпраляем сообщение пользователю на email (локально)
    public function sendEmail($items, $cartId, $email,$password = null){

        $totalAmount = CartItems::getTotalAmount($cartId);
        $totalPrice = CartItems::getTotalPrice($cartId);

        Yii::$app->mailer->compose('order',['items' => $items, 'password' => $password, 'totalAmount' => $totalAmount, 'totalPrice' => $totalPrice])
            ->setFrom(['test@yandex.ru' => 'eshopper'])
            ->setTo($email)
            ->setSubject('Заказ')->send();
    }
    //добавляет данные к уже существующему пользователю
    public function addDataToUser($user, $phone, $address){
        $user->phone = $phone;
        $user->address = $address;

        return $user->save();
    }
    //региструриует нового пользователя
    public function signUp($name, $email, $phone, $address, $password){
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;
        $user->setPassword($password);

        return $user->save();
    }
    //быстрая регистрация
    public function quickSignUp($name, $email, $password){
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->setPassword($password);

        return $user->save();
    }
}