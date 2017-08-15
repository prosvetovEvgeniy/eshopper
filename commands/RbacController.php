<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class RbacController extends Controller
{
    public function actionInit(){
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $customer = $auth->createRole('customer');

        $auth->add($admin);
        $auth->add($customer);

        $viewAdminModule = $auth->createPermission('viewAdminModule');
        $viewAdminModule->description = 'Просмотр админки';

        $buyGoods = $auth->createPermission('buyGoods');
        $buyGoods->description = 'Покупка товаров';

        $auth->add($viewAdminModule);
        $auth->add($buyGoods);

        $auth->addChild($customer, $buyGoods);
        $auth->addChild($admin, $customer);
        $auth->addChild($admin, $viewAdminModule);

        $adminUser = User::findOne(['email' => 'admin@mail.ru']);
        $auth->assign($admin, $adminUser->id);

        $users = User::find()->where("email != 'admin@mail.ru'")->all();

        foreach ($users as $user){
            $auth->assign($customer, $user->id);
        }
    }
}