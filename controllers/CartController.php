<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 15.07.2017
 * Time: 17:23
 */

namespace app\controllers;

use app\models\Category;
use app\models\Customer;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;
use yii\web\HttpException;

//контроллер отвечающий за работу с корзиной
class CartController extends AppController
{
    //добавляет товар в корзину
    public function actionAdd(){

        //получаем id товара и количество qty
        $id = Yii::$app->request->post('id');
        $qty = (int) Yii::$app->request->post('qty');

        //если товар добавляется в корзину не из контроллера products
        //а из контроллера category, то количество товара по умолчанию 1

        $qty = !$qty ? 1 : $qty;

        $product = Product::findOne($id);

        if(empty($product)) return false;

        //открываем сессию
        $session = Yii::$app->session;
        $session->open();

        //добавляем товар в session['cart']
        $cart = new Cart();
        $cart->addToCart($product, $qty);

        if(!Yii::$app->request->isAjax){
            return $this->redirect(Yii::$app->request->referrer);
        }
        //отключаем layout и показываем шаблон
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    //очищает сессию с данными о заказах
    public function actionClear(){
        $session = Yii::$app->session;

        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    //удаляет определенный товар из корзины
    public function actionDeleteItem(){
        $id = Yii::$app->request->post('id');

        $session = Yii::$app->session;
        $session->open();

        $cart = new Cart();
        $cart->recalculate($id);

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    //отображает корзину при отключенном javascript
    public function actionShow(){
        $session = Yii::$app->session;

        $session->open();

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    //отображает корзину при оформлении заказа и при отправке формы заполняет модель OrderItems
    public function actionView(){

        $session = Yii::$app->session;
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
        }

        $this->setMetaTags('Корзина');
        return $this->render('view', compact('session','customer'));
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