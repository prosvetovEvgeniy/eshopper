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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCartItems()
    {
        return $this->hasMany(CartItems::className(), ['cart_id' => 'id']);
    }
}
