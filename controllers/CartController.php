<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 15.07.2017
 * Time: 17:23
 */

namespace app\controllers;

use app\models\CartItems;
use app\models\CartTable;
use app\models\Category;
use app\models\Customer;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;
use yii\web\HttpException;
use thamtech\uuid\helpers\UuidHelper;

//контроллер отвечающий за работу с корзиной
class CartController extends AppController
{
    //добавляет товар в корзину
    public function actionAdd(){

        //получаем id товара и количество qty
        $id = Yii::$app->request->post('id');
        $qty = (int) Yii::$app->request->post('qty');

        $recordExists = Cart::findOne(['id' => $_COOKIE['uuid']]);
        if(!$recordExists){
            $cart = new Cart();
            $cart->id = $_COOKIE['uuid'];
            $cart->save();
        }
        else{
            $cart = $recordExists;
        }


        $qty = !$qty ? 1 : $qty;

        $product = Product::findOne($id);

        if(empty($product)) return false;

        $cartItem = new CartItems();
        $cartItem->addToCart($cart->id,$product->id, $qty);

        if(!Yii::$app->request->isAjax){
            return $this->redirect(Yii::$app->request->referrer);
        }

        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();

        //отключаем layout и показываем шаблон
        $this->layout = false;
        return $this->render('cart-modal', ['items' => $items]);
    }
    //очищает сессию с данными о заказах
    public function actionClear(){

        $cart = Cart::findOne(['id' => $_COOKIE['uuid']]);

        if(!$cart){
            return false;
        }

        CartItems::deleteAll(['cart_id' => $cart->id]);

        $this->layout = false;
        return $this->render('cart-modal');
    }

    //удаляет определенный товар из корзины
    public function actionDeleteItem(){

        $productId = Yii::$app->request->post('product_id');

        $cart = Cart::findOne(['id' => $_COOKIE['uuid']]);

        if(!$cart){
            return false;
        }

        $cartItem = new CartItems();
        $cartItem->removeItem($cart->id, $productId);

        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();

        $this->layout = false;
        return $this->render('cart-modal', ['items' => $items]);

    }

    //отображает корзину при отключенном javascript
    public function actionShow(){
        $cart = Cart::findOne(['id' => $_COOKIE['uuid']]);

        if(!$cart){
            return false;
        }

        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();

        //отключаем layout и показываем шаблон
        $this->layout = false;
        return $this->render('cart-modal', ['items' => $items]);
    }
    //отображает корзину при оформлении заказа и при отправке формы заполняет модель OrderItems
    public function actionView(){

        /*$session = Yii::$app->session;
        $session->open();

        $order = new Order();
        $customer = new Customer();

        //заполняем модель необходимыми данными
        if($customer->load((Yii::$app->request->post()))){

            $customerExists = Customer::find()->where("email = '{$customer->email}'")->one();

            if($customerExists){

                $customerExists->name = $customer->name;
                $customerExists->email = $customer->email;
                $customerExists->phone = $customer->phone;
                $customerExists->address = $customer->address;

                $customerExists->save();

                $order->customer_id = $customerExists->id;
                $order->save();

                $this->saveOrderItems($session['cart'], $order->id);

                $this->sendEmail($customerExists->email, $session);

                //сбрасываем данные формы
                return $this->refresh();
            }
            else{
                if($customer->save()){

                    $order->customer_id = $customer->id;
                    $order->save();

                    $this->saveOrderItems($session['cart'], $order->id);

                    Yii::$app->session->setFlash('success', 'Ваш заказ принят Менеджер скоро свяжется с вами.');

                    $this->sendEmail($customer->email, $session);

                    //сбрасываем данные формы
                    return $this->refresh();
                }
                else{
                    //если форма не провалидировалсь
                    Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');
                }
            }
        }*/
        $cart = Cart::findOne(['id' => $_COOKIE['uuid']]);

        if(!$cart){
            return false;
        }

        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();


        $this->setMetaTags('Корзина');
        return $this->render('view', ['items' => $items,
                                            'totalAmount' => CartItems::getTotalAmount($cart->id),
                                            'totalPrice' => CartItems::getTotalPrice($cart->id),
        ]);

        //return $this->render('view', compact('session','customer'));
    }

    public function sendEmail($email, $session){
        Yii::$app->session->setFlash('success', 'Ваш заказ принят Менеджер скоро свяжется с вами.');

        //отпраляем сообщение пользователю на email (пока локально)
        Yii::$app->mailer->compose('order',['session' => $session])
            ->setFrom(['test@yandex.ru' => 'eshopper'])
            ->setTo($email)
            ->setSubject('Заказ')->send();

        //очищаем сессию
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
    }

    //данный метод сохраняет данные каждого товара в таблицу order_items
    private function saveOrderItems($items,$order_id){

        foreach ($items as $id => $item){

            $order_items = new OrderItems();
            $order_items->order_id = $order_id; //номер заказа
            $order_items->product_id = $id; //ид товара
            $order_items->name = $item['name']; //название (на момент заказа)
            $order_items->price = $item['price']; //цену (на момент заказа)
            $order_items->qty_item = $item['qty']; //количество
            $order_items->save();
        }

    }
}