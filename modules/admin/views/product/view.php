<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */


$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
            [
                'attribute' => 'image',
                'value' => "<img src='{$imgUrl}'>",
                'format' => 'html',
            ],
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
        ],
    ]) ?>

</div>
