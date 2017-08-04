<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $qty
 * @property double $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 *
 * @property OrderItems[] $orderItems
 */
class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'name', 'email', 'phone', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['amount'], 'integer'],
            [['totalSum'], 'number'],
            [['status'], 'string'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
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

        //return $this->hasMany(OrderItems::className(),['order_id' => 'id'])->sum('qty_item');
    }

    public function getTotalSum(){

        $totalSum = 0;

        foreach($this->orderItems as $item){
            $totalSum += $item->price * $item->qty_item;
        }

        return $totalSum;

        //return $this->hasMany(OrderItems::className(),['order_id' => 'id'])->sum('price * qty_item');
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }
}
