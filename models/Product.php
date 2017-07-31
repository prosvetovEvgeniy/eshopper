<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 08.07.2017
 * Time: 18:17
 */

namespace app\models;


use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName()
    {
        return 'product';
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}