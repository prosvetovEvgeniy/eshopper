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
    //отображает индексную страницу с товарами хитами
    public function actionIndex(){

        $hits = Product::find()->where(['hit' => '1', 'deleted' => 0])->limit(6)->all();

        $this->setMetaTags('Eshopper');
        return $this->render('index', ['hits' => $hits]);
    }
    //отображает определенную категорию товаров
    public function actionView($id){

        $category = Category::find()->where(['id' => $id])->one();

        //если пользователь обратился к несуществующей категории
        if(empty($category)){
            throw new HttpException(404, 'Такой категории не существует');
        }
        //пагинация
        $query = Product::find()->where(['category_id' => $id, 'deleted' => 0]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMetaTags('Eshopper ' . $category['name'],  $category['keywords'], $category['description']);
        return $this->render('view', compact('products', 'category', 'pages'));
    }
    //поиск товара по названию
    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));

        $this->setMetaTags('Eshopper | поиск' . $q);
        if(!$q)
            return $this->render('search');

        $query = Product::find()->where(['like', 'name', $q])->andFilterWhere(['deleted' => 0]);

        //пагинация
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 9, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMetaTags('Eshopper | поиск' . $q);
        return $this->render('search', compact('products', 'category', 'pages', 'q'));
    }

}