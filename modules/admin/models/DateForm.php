<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 19.08.2017
 * Time: 15:01
 */

namespace app\modules\admin\models;


use yii\base\Model;

class DateForm extends Model
{
    public $year;
    public $month;

    public function rules()
    {
        return [
            [['year', 'month'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'year' => 'Год',
            'month' => 'Месяц',
        ];
    }
}