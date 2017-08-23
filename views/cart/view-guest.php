<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="container">

    <?php if(Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    &times;
                </span>
            </button>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    &times;
                </span>
            </button>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if(count($items) > 0) : ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                    <th><span class="glyphicon glyphicon-remove"></span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item) : ?>
                    <tr>
                        <td><?= \yii\helpers\Html::img("{$item->product->getImage()->getUrl()}", ['alt' => $item->product->name, 'height' => 50]) ?></td>
                        <td><?= $item->product->name; ?></td>
                        <td><?= $item->amount; ?></td>
                        <td><?= $item->product->price; ?></td>
                        <td><?= $item->product->price * $item->amount ?></td>
                        <td><span data-id="<?= $item->product_id ?>" class="glyphicon glyphicon-remove text-danger del-item"></span></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">Итого</td>
                    <td><?= $totalAmount ?></td>
                </tr>
                <tr>
                    <td colspan="4">На сумму</td>
                    <td><?= $totalPrice ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr/>

        <?php if(Yii::$app->user->isGuest): ?>

            <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'phone')->textInput() ?>

            <?= $form->field($model, 'address')->textInput() ?>

            <?= Html::submitButton('Оформить покупку', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

            <?php ActiveForm::end(); ?>

        <?php else : ?>
        <?php endif; ?>

        <br>
        <br>
    <?php else : ?>
        <h3>Корзина пуста</h3>
    <?php endif; ?>








































