<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 15.07.2017
 * Time: 17:26
 */

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    //добавляет данные в массив сессии
    public function addToCart($product, $qty = 1){
        //если массив ['cart'] с данным id товара существует, то увеличиваем количество данного товара в корзине
        if(isset($_SESSION['cart'][$product->id]))
        {
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        }
        else{
            $mainImg = $product->getImage();
            //если не существует то создаем такой массив
            $_SESSION['cart'][$product->id] = [
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $mainImg->getUrl('x50')
            ];
        }
        //поле qty итоговое количество товара в корзине, поле sum итоговая сумма всего заказа
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }
    //отвечает за перерасчет количества товара и суммы при удалении какого либо товара из корзины
    public function recalculate($id){
        if(!isset($_SESSION['cart'][$id])) return false;

        $qtyMinus = $_SESSION['cart'][$id]['qty']; //какое количество удаляемого товара нужно отнять от итогового количества
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price']; //отнимаемая сумма

        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
     }
}