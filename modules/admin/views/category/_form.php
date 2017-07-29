<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Выводим модифицированный вариант dropdawnlist -->
    <div class="form-group field-category-parent_id required has-success">
    <label class="control-label" for="category-parent_id">Родительская категория</label>
    <select id="category-parent_id" class="form-control" name="Category[parent_id]" aria-required="true" aria-invalid="false">
        <option value="0">Самостоятельная категория</option>
        <?= \app\components\MenuWidget::widget(['tpl' => 'select', 'model' => $model]) ?>
    </select>
    </div>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
