<?php

namespace app\modules\admin\models;

use Yii;


class Product extends \yii\db\ActiveRecord
{
    public $image;
    public $gallery;

    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    public function rules()
    {
        return [
            [['category_id', 'name', 'content', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'new', 'hit', 'sale'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'category_id' => 'Категория',
            'name' => 'Название',
            'content' => 'Наименование',
            'price' => 'Цена',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'image' => 'Изображение',
            'gallery' => 'Галерея',
            'new' => 'Новинка',
            'hit' => 'Хит',
            'sale' => 'Распродажа',
        ];
    }

    public function upload(){

        if($this->validate()){
            //сохраняем картинку
            $path = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);

            return true;
        }
        else{
            return false;
        }
    }
    public function uploadGallery(){

        if($this->validate()){

            foreach ($this->gallery as $file) {
                //сохраняем картинку в галерею
                $path = 'upload/store/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                @unlink($path);

            }
            return true;
        }
        else{
            return false;
        }
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
