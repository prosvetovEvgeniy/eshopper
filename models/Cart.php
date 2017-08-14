<?php

namespace app\models;

use Yii;
use thamtech\uuid\helpers\UuidHelper;
use app\models\User;

class Cart extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cart';
    }

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
        ];
    }
    //создает новое поля в таблице Cart с id и user_id
    public function setNewUser($email){
        $user = User::findOne(['email' => $email]);

        $uuid = UuidHelper::uuid();
        $this->id = $uuid;
        $this->user_id = $user->id;

        $this->save();
    }
    //добавляет user_id при существующем id
    public function addUserId($id, $email){

        $cart = self::findOne(['id' => $id]);
        $user = User::findOne(['email' => $email]);

        $cart->user_id = $user->id;
        $cart->save();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCartItems()
    {
        return $this->hasMany(CartItems::className(), ['cart_id' => 'id']);
    }
}
