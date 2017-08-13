<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;


class Customer extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'customer';
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

    public function setUuid($customer){
        $cart = Cart::findOne(['customer_id' => $customer->id]);

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
