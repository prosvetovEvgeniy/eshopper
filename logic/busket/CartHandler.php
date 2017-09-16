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
    protected $uuid;

    public function __construct($uuid = null)
    {
        if($uuid == null){
            $this->uuid = $_COOKIE['uuid'];
            $this->cart = Cart::findOne(['id' => $this->uuid]);
        }
        else{
            $this->uuid = $uuid;
            $this->cart = Cart::findOne(['id' => $this->uuid]);
        }
    }

    //создает корзину для пользователя
    public function createCart(){
        if(!$this->cart){
            $this->cart = new Cart();
            $this->cart->id = $this->uuid;
            $this->cart->save();
        }
    }

    //прикрипляет id пользователя к корзине
    public function attachUserToCart($email){

        $user = User::findOne(['email' => $email]);
        $uuid = UuidHelper::uuid();

        $cart = new Cart();
        $cart->id = $uuid;
        $cart->user_id = $user->id;
        $cart->save();
    }

    //полностью очищает корзину
    public function clearCart(){
        CartItems::deleteAll(['cart_id' => $this->cart->id]);
    }

    //добавляет user_id при существующем cart_id
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