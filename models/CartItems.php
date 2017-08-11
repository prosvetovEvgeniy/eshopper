<?php

namespace app\models;

use Yii;


class CartItems extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cart_items';
    }

    public function rules()
    {
        return [
            [['cart_id', 'product_id'], 'required'],
            [['product_id', 'amount'], 'integer'],
            [['cart_id'], 'string', 'max' => 36],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cart_id' => 'Cart ID',
            'product_id' => 'Product ID',
            'amount' => 'Amount',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }
    //удаляет товар из корзины
    public function removeItem($cartId, $productId){

        $cartItem = self::findOne(['cart_id' => $cartId, 'product_id' => $productId]);

        if($cartItem->amount > 1){
            $cartItem->amount -= 1;
            $cartItem->save();
        }
        else{
            $cartItem->delete();
        }
    }
    //добавляет товар в корзину
    public function addToCart($cartId, $productId, $amount = 1){

        $cartItem = self::findOne(['cart_id' => $cartId, 'product_id' => $productId]);

        if($cartItem){
            $cartItem->amount += $amount;
            $cartItem->save();
        }
        else{
            $this->cart_id = $cartId;
            $this->product_id = $productId;
            $this->amount = $amount;
            $this->save();
        }
    }
    //возвращает количество всех товаров для определенного cartId
    public function getTotalAmount($cartId){

        $cartItems = CartItems::find()->where(['cart_id' => $cartId])->all();
        $totalAmount = 0;

        foreach ($cartItems as $cartItem){
            $totalAmount += $cartItem->amount;
        }

        return $totalAmount;
    }
    //возвращает цену общую цену всех товаров для определенного cartId
    public function getTotalPrice($cartId){

        $cartItems = CartItems::find()->where(['cart_id' => $cartId])->all();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem){
            $totalPrice += $cartItem->amount * $cartItem->product->price;
        }

        return $totalPrice;
    }
}
