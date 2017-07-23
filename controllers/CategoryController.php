<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 09.07.2017
 * Time: 23:03
 */

namespace app\controllers;

use yii\data\Pagination;
use yii\web\Controller;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\web\HttpException;

class CategoryController extends AppController
{
    public function actionIndex(){

        $hits = Product::find()->where(['hit' => '1'])->limit(6)->asArray()->all();

        $this->setMetaTags('Eshopper');
        return $this->render('index', compact('hits'));
    }

    public function actionView($id){

        $category = Category::find()->where(['id' => $id])->asArray()->one();

        if(empty($category)){
            throw new HttpException(404, 'Такой категории не существует');
        }

        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMetaTags('Eshopper ' . $category['name'],  $category['keywords'], $category['description']);
        return $this->render('view', compact('products', 'category', 'pages'));
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));

        $this->setMetaTags('Eshopper | поиск' . $q);
        if(!$q)
            return $this->render('search');

        $query = Product::find()->where(['like', 'name', $q]);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMetaTags('Eshopper | поиск' . $q);
        return $this->render('search', compact('products', 'category', 'pages', 'q'));
    }

}