<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 13.07.2017
 * Time: 14:47
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\web\HttpException;

class ProductController extends AppController
{
    //отображает информацию об определенном товаре
    public function actionView($id){

        $product = Product::findOne($id);

        if(empty($product)){
            throw new HttpException(404, 'Такого товара нет');
        }
        //данные для окна "Recommended items" в виде view
        $hits = Product::find()->where(['hit' => '1', 'deleted' => 0])->limit(6)->all();

        $this->setMetaTags('Eshopper ' . $product['name'],  $product['keywords'], $product['description']);

        $mainImg = $product->getImage(); //главная картинка для товара
        $gallery = $product->getImages(); //галерея картинок

        return $this->render('view', ['product' => $product,
                                            'hits' => $hits,
                                            'mainImg' => $mainImg->getUrl(),
                                            'gallery' => $gallery,
                                            ]);

    }
}