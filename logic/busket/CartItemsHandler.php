<?php

namespace app\logic\busket;

use  app\models\Product;
use app\models\CartItems;
use Yii;

class CartItemsHandler
{
    protected $product;
    protected $cartId;
    protected $amount;

    public function __construct($product = null, $amount = null)
    {
        $this->cartId = Yii::createObject(CartHandler::class)->getCartId();
        $this->product = $product;
        $this->amount = !$amount ? 1 : $amount;
    }

    //удаляет товар из корзины
    public function removeItem(){
        $cartItem = CartItems::findOne(['cart_id' => $this->cartId, 'product_id' => $this->product->id]);

        if($cartItem->amount > 1){
            $cartItem->amount -= 1;
            $cartItem->save();
        }
        else{
            $cartItem->delete();
        }
    }

    //сохраняет товар в корзину
    public function saveItem(){
        $cartItem = CartItems::findOne(['cart_id' => $this->cartId, 'product_id' => $this->product->id]);

        if($cartItem){
            $cartItem->amount += $this->amount;
            $cartItem->save();
        }
        else{
            $cartItem = new CartItems();
            $cartItem->cart_id = $this->cartId;
            $cartItem->product_id = $this->product->id;
            $cartItem->amount = $this->amount;
            $cartItem->save();
        }
    }
}