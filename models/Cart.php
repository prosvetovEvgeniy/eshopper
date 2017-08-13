<?php

namespace app\models;

use Yii;
use thamtech\uuid\helpers\UuidHelper;

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
    //создает новое поля в таблице Cart с id и customer_id
    public function setNewCustomer($email){
        $customer = Customer::findOne(['email' => $email]);

        $uuid = UuidHelper::uuid();
        $this->id = $uuid;
        $this->customer_id = $customer->id;

        $this->save();
    }
    //добавляет customer_id при существующем id
    public function addCustomerId($id, $email){

        $cart = self::findOne(['id' => $id]);
        $customer = Customer::findOne(['email' => $email]);

        $cart->customer_id = $customer->id;
        $cart->save();
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
