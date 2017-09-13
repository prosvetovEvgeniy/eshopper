<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 14.08.2017
 * Time: 17:16
 */

namespace app\models;


use yii\base\Model;

class AddUserDataForm extends Model
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

}