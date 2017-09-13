<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 12.09.2017
 * Time: 21:32
 */

namespace app\logic\busket;

use app\models\Cart;
use app\models\User;
use app\models\CartItems;
use thamtech\uuid\helpers\UuidHelper;

class CartHandler
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Cart::findOne(['id' => $_COOKIE['uuid']]);
    }

    public function createCart($email = null){
        if(!$this->cart && $email == null) {
            $this->cart = new Cart();
            $this->cart->id = $_COOKIE['uuid'];
            $this->cart->save();
        }
        elseif($email != null)
        {
            $user = User::findOne(['email' => $email]);
            $uuid = UuidHelper::uuid();

            $this->cart = new Cart();
            $this->cart->id = $uuid;
            $this->cart->user_id = $user->id;
            $this->cart->save();
        }
    }

    public function clearCart(){
        CartItems::deleteAll(['cart_id' => $this->cart->id]);
    }

    //добавляет user_id при существующем id
    public function addUserId($email){

        $user = User::findOne(['email' => $email]);
        $this->cart->user_id = $user->id;
        $this->cart->save();
    }

    public function getCart(){
        return $this->cart;
    }

    public function getCartId(){
        return $this->cart->id;
    }
}