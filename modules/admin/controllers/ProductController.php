<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Category;
use app\modules\admin\models\Image;
use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\controllers\ProductSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


class ProductController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $categoryArray = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryArray' => $categoryArray,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $img = $model->getImage(); // получаем картинки из модели для отображения в виде

        return $this->render('view', [
            'model' => $model,
            'imgUrl' => $img->getUrl(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        $categoryArray = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //получаем экземпляр класса UploadFile для главной картинки
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->image){
                $model->upload();
            }
            unset($model->image);

            //получаем экземпляр класса UploadFile для галереи картинок
            $model->gallery = UploadedFile::getInstances($model, 'gallery');
            if($model->gallery){
                $model->uploadGallery(); //загружаем галерею в БД
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categoryArray' => $categoryArray,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $categoryArray = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //получаем экземпляр класса UploadFile для главной картинки
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->image){
                $model->upload();
            }
            unset($model->image);

            //получаем экземпляр класса UploadFile для галереи картинок
            $model->gallery = UploadedFile::getInstances($model, 'gallery');
            if($model->gallery){
                $model->uploadGallery();
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
                'categoryArray' => $categoryArray,
            ]);
        }
    }

    /*public function actionDelete($id)
    {
        //удаляем фотографии товара
        Image::deleteAll("itemId = {$id}");

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/


    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
