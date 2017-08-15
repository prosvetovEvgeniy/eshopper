<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 15.07.2017
 * Time: 17:23
 */

namespace app\controllers;

use app\models\AddUserDataForm;
use app\models\CartItems;
use app\models\CartTable;
use app\models\Category;
use app\models\User;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use app\models\QuickSignup;
use app\models\Signup;
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

    //корзина для зарегистрированного пользователя
    public function actionView(){

        $model = new AddUserDataForm();

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $cart = Cart::findOne(['user_id' => $user->id]);
        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();

        if($model->load(Yii::$app->request->post())){

            if($model->validate() && $model->addData($user->email)){


                //заполняем таблицу order
                $order = new Order();
                $order->user_id = $user->id;
                $order->save();

                //сохраняем данные в таблицу OrderItems
                $this->saveOrderItems($items, $order->id);

                //отправляем пользователю сообщение на почту
                $this->sendEmail($user->email, $items, CartItems::getTotalAmount($cart->id), CartItems::getTotalPrice($cart->id));

                //удаляем товары из корзины
                CartItems::deleteAll(['cart_id' => $cart->id]);

                Yii::$app->session->setFlash('success', 'Ваш заказ принят Менеджер скоро свяжется с вами.');
                return $this->refresh();
            }
        }

        return $this->render('view', [
            'items' => $items,
            'model' => $model,
            'totalAmount' => CartItems::getTotalAmount($cart->id),
            'totalPrice' => CartItems::getTotalPrice($cart->id),
        ]);
    }

    //корзина для незарегистрированного пользователя
    public function actionViewGuest(){

        $model = new QuickSignup();

        $cart = Cart::findOne(['id' => $_COOKIE['uuid']]);
        $items = CartItems::find()->where(['cart_id' => $cart->id])->orderBy('cart_id')->all();

        if($model->load(Yii::$app->request->post())){

            $password = Yii::$app->getSecurity()->generateRandomString(8);

            if($model->validate() && $model->signup($password)){

                //записываем id пользователя для уже существующей записи в таблице cart
                Cart::addUserId($cart->id, $model->email);

                //заполняем таблицу order
                $order = new Order();
                $order->user_id = $model->getUserId();
                $order->save();

                //сохраняем данные в таблицу OrderItems
                $this->saveOrderItems($items, $order->id);

                //отправляем пользователю сообщение на почту
                $this->sendEmail($model->email, $items, CartItems::getTotalAmount($cart->id), CartItems::getTotalPrice($cart->id), $password);

                //удаляем товары из корзины
                CartItems::deleteAll(['cart_id' => $cart->id]);
                //создаем новый uuid в куки
                setcookie('uuid', UuidHelper::uuid(), time() + 3600*24*30, '/');

                Yii::$app->session->setFlash('success', 'Ваш заказ принят Менеджер скоро свяжется с вами.');
                return $this->refresh();
            }
        }

        return $this->render('view-guest', [
            'items' => $items,
            'model' => $model,
            'totalAmount' => CartItems::getTotalAmount($cart->id),
            'totalPrice' => CartItems::getTotalPrice($cart->id),
        ]);
    }

    public function sendEmail($email, $items, $totalAmount, $totalPrice, $password = null){
        //отпраляем сообщение пользователю на email (пока локально)
        Yii::$app->mailer->compose('order',['items' => $items, 'password' => $password, 'totalAmount' => $totalAmount, 'totalPrice' => $totalPrice])
            ->setFrom(['test@yandex.ru' => 'eshopper'])
            ->setTo($email)
            ->setSubject('Заказ')->send();
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