<?php

namespace app\logic\order;

use app\logic\user\UserHandler;
use app\models\OrderItems;
use app\models\Order;
use Yii;

class OrderHandler
{
    public function __construct()
    {
    }

    public function saveOrder($items,$email){
        $userId = Yii::createObject(UserHandler::class, [$email])->getUserId();

        $order = new Order();
        $order->user_id = $userId;
        $order->save();

        $this->saveOrderItems($items, $order->id);
    }

    //данный метод сохраняет данные каждого товара в таблицу order_items
    private function saveOrderItems($items,$order_id){

        foreach ($items as $item){
            $order_items = new OrderItems();
            $order_items->order_id = $order_id; //номер заказа
            $order_items->product_id = $item->product->id; //ид товара
            $order_items->name = $item->product->name; //название (на момент заказа)
            $order_items->price = $item->product->price; //цену (на момент заказа)
            $order_items->qty_item = $item->amount; //количество
            $order_items->save();
        }

    }
}