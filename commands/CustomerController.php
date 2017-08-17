<?php

namespace app\commands;

use app\models\Cart;
use app\models\Product;
use app\models\User;
use yii\console\Controller;
use Yii;

class CustomerController extends Controller
{
    public function actionSimulate($days = 30, $botEmail = 'bot@mail.ru'){

        $db = Yii::$app->db;
        //очищаем таблицы order и order_items
        $db->createCommand('TRUNCATE TABLE `order`')->query();
        $db->createCommand('TRUNCATE TABLE `order_items`')->query();

        //если бота не существует создаем его или получаем
        if(!User::findOne(['email' => $botEmail])){
            $bot = $this->getBot($botEmail, '12345');
        }
        else{
            $bot = User::findOne(['email' => $botEmail]);
        }
        //получаем все товары
        $products = Product::find()->all();

        for($i = 0; $i < $days; $i++){

            $purchasesPerDay = mt_rand(15, 40); //случайная величина, количество покупок в день

            for($j = 0; $j < $purchasesPerDay; $j++){

                $randProduct = $products[mt_rand(0,count($products)-1)]; //получаем случайный товар

                //вставляем значения в таблицу order
                $db->createCommand("INSERT INTO `order` (`created_at`, `updated_at`, `user_id`) 
                                        VALUES (NOW() + INTERVAL {$i} DAY, NOW() + INTERVAL {$i} DAY, {$bot->id})")->query();

                $lastOrderId = Yii::$app->db->lastInsertID ;
                $productsAmount = mt_rand(1,2); //количетсво товара, который покупает бот

                //вставляем значения в таблицу order_items
                $db->createCommand("INSERT INTO `order_items` (`order_id`, `product_id`, `name`, `price`, `qty_item`)
                                        VALUES ({$lastOrderId}, {$randProduct->id}, '{$randProduct->name}', {$randProduct->price}, {$productsAmount})")->query();
            }
        }
    }

    //создает пользователя с ником bot и указанным email
    public function getBot($email, $password){
        $bot = new User();
        $bot->name = 'bot';
        $bot->email = $email;
        $bot->password = Yii::$app->security->generatePasswordHash($password);
        $bot->save();

        $cart = new Cart();
        $cart->setNewUser($bot->email);

        return $bot;
    }
}