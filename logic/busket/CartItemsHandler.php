<?php

namespace app\logic\busket;

use  app\models\Product;
use app\models\CartItems;
use Yii;

class CartItemsHandler
{
    protected $product;
    protected $cart;
    protected $amount;

    public function __construct($cart = null,$product = null, $amount = null)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->amount = !$amount ? 1 : $amount;
    }
    //сохраняет товар в корзину
    public function saveItem(){
        $cartItem = CartItems::findOne(['cart_id' => $this->cart->id, 'product_id' => $this->product->id]);

        if($cartItem){
            $cartItem->amount += $this->amount;
            $cartItem->save();
        }
        else{
            $cartItem = new CartItems();
            $cartItem->cart_id = $this->cart->id;
            $cartItem->product_id = $this->product->id;
            $cartItem->amount = $this->amount;
            $cartItem->save();
        }
    }
    //удаляет товар из корзины
    public function removeItem(){
        $cartItem = CartItems::findOne(['cart_id' => $this->cart->id, 'product_id' => $this->product->id]);

        if($cartItem->amount > 1){
            $cartItem->amount -= 1;
            $cartItem->save();
        }
        else {
            $cartItem->delete();
        }
    }
}