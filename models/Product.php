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

    public function rules()
    {
        return [
            [['category_id', 'name', 'content', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['content'], 'string'],
            [['new', 'hit', 'sale'], 'boolean'],
            [['price'], 'number'],
            [['name', 'keywords', 'description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}