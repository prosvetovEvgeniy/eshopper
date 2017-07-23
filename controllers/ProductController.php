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
    public function actionView($id){

        $product = Product::findOne($id);

        if(empty($product)){
            throw new HttpException(404, 'Такого товара нет');
        }

        $hits = Product::find()->where(['hit' => '1'])->limit(6)->asArray()->all();

        $this->setMetaTags('Eshopper ' . $product['name'],  $product['keywords'], $product['description']);
        return $this->render('view', compact('product', 'hits'));
    }
}