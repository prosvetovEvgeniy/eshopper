<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 13.08.2017
 * Time: 14:34
 */

namespace app\models;


use yii\base\Model;

class Signup extends Model
{
    public $name;
    public $email;
    public $password;
    public $phone;
    public $address;

    public function rules(){
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User'],
            ['password', 'string', 'min' => 2, 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}