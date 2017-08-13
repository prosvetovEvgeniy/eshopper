<?php

namespace app\models;

use Yii;
use yii\base\Model;


class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $customer = Customer::findOne(['email' => $this->email]);

        if(!$customer || !$customer->validatePassword($this->password))
        {
            $this->addError($attribute, 'Пароль или пользователь введены не верно');
        }
    }

    public function getUser(){
        return Customer::findOne(['email' => $this->email]);
    }
}
