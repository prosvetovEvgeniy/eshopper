<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\controllers\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return !$data->category->name ? 'Категория не задана' : $data->category->name;
                },
                'filter' => $categoryArray,
            ],
            'name',
            'price',
             'keywords',
             'description',
             [
                'attribute' => 'hit',
                'value' => function($data){
                    return !$data->hit ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                },
                'filter' => ['0' => 'Нет', '1' => 'Да'],
                'format' => 'html',
             ],
             [
                 'attribute' => 'new',
                 'value' => function($data){
                    return !$data->new ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                 },
                 'filter' => ['0' => 'Нет', '1' => 'Да'],
                 'format' => 'html',
             ],
             [
                'attribute' => 'sale',
                'value' => function($data){
                    return !$data->sale ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                },
                'filter' => ['0' => 'Нет', '1' => 'Да'],
                'format' => 'html',
             ],
             [
                'attribute' => 'deleted',
                'value' => function($data){
                    return !$data->deleted ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                },
                'filter' => ['0' => 'Нет', '1' => 'Да'],
                'format' => 'html',
             ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view}',
                //'template' => '{update} {view} {delete}',
            ],
        ],
    ]); ?>
</div>
