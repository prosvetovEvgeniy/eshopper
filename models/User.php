<?php

namespace app\models;

use Yii;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;


class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //добавляем роль зарегистрировавшемуся пользователю
        if(Yii::$app->user->isGuest){
            $auth = Yii::$app->authManager;
            $auth = Yii::createObject(DbManager::class);
            $customer = $auth->getRole('customer');
            $auth->assign($customer, $this->id);
        }
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public function getId(){
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null){

    }

    public function getAuthKey(){

    }

    public function validateAuthKey($authKey){

    }

    public function setPassword($pass){
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($pass);
    }

    public function setUuid($user){
        $cart = Cart::findOne(['user_id' => $user->id]);

        setcookie('uuid', $cart->id,time() + 3600*24*60, "/");
    }

    public function validatePassword($pass){

        if(Yii::$app->getSecurity()->validatePassword($pass, $this->password)){
            return true;
        }
        else {
            return false;
        }
    }
}
