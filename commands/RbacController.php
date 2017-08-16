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
        $manager = $auth->createRole('manager');
        $contentManager = $auth->createRole('contentManager');
        $customer = $auth->createRole('customer');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($contentManager);
        $auth->add($customer);

        $superUser = $auth->createPermission('superUser');
        $superUser->description = "Права супер пользователя(admin)";

        $workWitnOrders = $auth->createPermission('workWithOrders');
        $workWitnOrders->description = 'Работать с заказами';

        $workWitnContent= $auth->createPermission('workWithContent');
        $workWitnContent->description = 'Работать с контентом сайта';

        $viewAdminModule = $auth->createPermission('viewAdminModule');
        $viewAdminModule->description = 'Просмотр админки';

        $buyGoods = $auth->createPermission('buyGoods');
        $buyGoods->description = 'Покупка товаров';

        $auth->add($superUser);
        $auth->add($workWitnOrders);
        $auth->add($workWitnContent);
        $auth->add($viewAdminModule);
        $auth->add($buyGoods);

        $auth->addChild($customer, $buyGoods);
        $auth->addChild($contentManager, $customer);
        $auth->addChild($contentManager, $viewAdminModule);
        $auth->addChild($contentManager, $workWitnContent);
        $auth->addChild($manager, $contentManager);
        $auth->addChild($manager, $workWitnOrders);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $superUser);

        $users = User::find()->all();

        foreach ($users as $user){
           if($user->email == "admin@mail.ru"){
               $auth->assign($admin, $user->id);
           }
           elseif ($user->email == "manager@mail.ru"){
               $auth->assign($manager, $user->id);
           }
           elseif ($user->email == "contentManager@mail.ru"){
               $auth->assign($contentManager, $user->id);
           }
           else{
               $auth->assign($customer, $user->id);
           }
        }
    }
}