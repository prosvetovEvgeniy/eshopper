<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 14.08.2017
 * Time: 1:57
 */

namespace app\models;


use yii\base\Model;

class AddCustomerDataForm extends Model
{
    public $phone;
    public $address;

    public function rules(){
        return [
            [['phone','address'], 'required'],
            ['phone', 'string'],
            ['address', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'address' => 'Адрес',
        ];
    }

    public function addData($email){

        $customer = Customer::findOne(['email' => $email]);

        $customer->phone = $this->phone;
        $customer->address = $this->address;

        return $customer->save();
    }
}