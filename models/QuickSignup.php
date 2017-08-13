<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 13.08.2017
 * Time: 14:34
 */

namespace app\models;


use yii\base\Model;

class QuickSignup extends Model
{
    public $name;
    public $email;
    public $phone;
    public $address;

    public function rules(){
        return [
            [['name', 'email', 'phone','address'], 'required'],
            ['email', 'email'],
            ['phone', 'string'],
            ['address', 'string'],
            ['email', 'unique', 'targetClass' => 'app\models\Customer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'address' => 'Адрес',
        ];
    }
    public function getCustomerId(){
        $customer = Customer::findOne(['email' => $this->email]);
        return $customer->id;
    }
    public function signup($password){

        $customer = new Customer();

        $customer->name = $this->name;
        $customer->email = $this->email;
        $customer->phone = $this->phone;
        $customer->address = $this->address;
        $customer->setPassword($password);

        return $customer->save();
    }

}