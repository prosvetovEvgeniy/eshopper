<?php

namespace app\models;

use Yii;

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
            [['customer_id'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getCartItems()
    {
        return $this->hasMany(CartItems::className(), ['cart_id' => 'id']);
    }
}
