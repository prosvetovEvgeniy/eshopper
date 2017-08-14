<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string'],
            [['user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '№ заказа',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'amount' => 'Количество',
            'totalSum' => 'Сумма',
            'status' => 'Статус',
            'user_id' => 'Ид покупателя',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'address' => 'Адрес',
        ];
    }

    public function getAmount(){

        $amount = 0;

        foreach($this->orderItems as $item){
            $amount += $item->qty_item;
        }

        return $amount;
    }

    public function getTotalSum(){

        $totalSum = 0;

        foreach($this->orderItems as $item){
            $totalSum += $item->price * $item->qty_item;
        }

        return $totalSum;
    }
    public function getName(){
        return $this->user->name;
    }
    public function getEmail(){
        return $this->user->email;
    }
    public function getPhone(){
        return $this->user->phone;
    }
    public function getAddress(){
        return $this->user->address;
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }
}
