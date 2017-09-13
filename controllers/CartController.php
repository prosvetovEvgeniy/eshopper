<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 15.07.2017
 * Time: 17:23
 */

namespace app\controllers;

use app\logic\busket\CartHandler;
use app\logic\busket\CartItemsHandler;
use app\logic\order\OrderHandler;
use app\logic\user\UserHandler;
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
        $productId = Yii::$app->request->post('id');
        $amount = (int) Yii::$app->request->post('qty');

        Yii::createObject(CartHandler::class)->createCart();

        Yii::createObject(CartItemsHandler::class, [$productId, $amount])->save();

        $items = CartItems::find()->where(['cart_id' => $_COOKIE['uuid']])->orderBy('cart_id')->all();

        $this->layout = false;
        return $this->render('cart-modal', ['items' => $items]);
    }
    
    //очищает сессию с данными о заказах
    public function actionClear(){

        Yii::createObject(CartHandler::class)->clearCart();

        $this->layout = false;
        return $this->render('cart-modal');
    }

    //удаляет определенный товар из корзины
    public function actionDeleteItem(){
        $productId = Yii::$app->request->post('product_id');

        Yii::createObject(CartItemsHandler::class, [$productId])->remove();

        $items = CartItems::find()->where(['cart_id' => $_COOKIE['uuid']])->orderBy('cart_id')->all();

        $this->layout = false;
        return $this->render('cart-modal', ['items' => $items]);
    }

    //корзина для зарегистрированного пользователя
    public function actionView(){

        $model = new AddUserDataForm();
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $items = CartItems::find()->where(['cart_id' => $_COOKIE['uuid']])->orderBy('cart_id')->all();

        if($model->load(Yii::$app->request->post())){
            if($model->validate() && (new UserHandler($user->email))->addDataToUser()){

                Yii::createObject(OrderHandler::class)->saveOrder($items, $user->email);

                Yii::createObject(UserHandler::class, [$user->email])->sendEmail($items, (new CartHandler())->getCartId());

                Yii::createObject(CartHandler::class)->clearCart();

                Yii::$app->session->setFlash('success', 'Ваш заказ принят Менеджер скоро свяжется с вами.');
                return $this->refresh();
            }
        }

        return $this->render('view', [
            'items' => $items,
            'model' => $model,
            'totalAmount' => CartItems::getTotalAmount((new CartHandler())->getCartId()),
            'totalPrice' => CartItems::getTotalPrice((new CartHandler())->getCartId()),
        ]);
    }

    //корзина для незарегистрированного пользователя
    public function actionViewGuest(){

        $model = new QuickSignup();
        $cartHandler = new CartHandler();
        $items = CartItems::find()->where(['cart_id' => $_COOKIE['uuid']])->orderBy('cart_id')->all();

        if($model->load(Yii::$app->request->post())){

            $password = Yii::$app->getSecurity()->generateRandomString(8);

            if($model->validate() && $model->signup($password)){

                $cartHandler->addUserId($model->email);

                Yii::createObject(OrderHandler::class)->saveOrder($items, $model->email);

                Yii::createObject(UserHandler::class, [$model->email])->sendEmail($items, $cartHandler->getCartId(), $password);

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

}