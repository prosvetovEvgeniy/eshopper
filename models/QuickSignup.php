<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 13.08.2017
 * Time: 14:34
 */

namespace app\models;


use yii\base\Model;
use app\models\User;

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
            ['email', 'unique', 'targetClass' => 'app\models\User'],
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
}