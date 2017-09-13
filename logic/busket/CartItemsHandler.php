<?php

namespace app\logic\busket;

use  app\models\Product;
use app\models\CartItems;
use Yii;

class CartItemsHandler
{
    protected $productId;
    protected $cartId;
    protected $amount;

    public function __construct($productId = null, $amount = null)
    {
        $product = Product::findOne($productId);

        $this->cartId = Yii::createObject(CartHandler::class)->getCartId();
        $this->productId = $product->id;
        $this->amount = !$amount ? 1 : $amount;
    }

    public function remove(){

        $cartItem = CartItems::findOne(['cart_id' => $this->cartId, 'product_id' => $this->productId]);

        if($cartItem->amount > 1){
            $cartItem->amount -= 1;
            $cartItem->save();
        }
        else{
            $cartItem->delete();
        }
    }

    public function save(){
        $cartItem = CartItems::findOne(['cart_id' => $this->cartId, 'product_id' => $this->productId]);

        if($cartItem){
            $cartItem->amount += $this->amount;
            $cartItem->save();
        }
        else{
            $cartItem = new CartItems();
            $cartItem->cart_id = $this->cartId;
            $cartItem->product_id = $this->productId;
            $cartItem->amount = $this->amount;
            $cartItem->save();
        }
    }
}