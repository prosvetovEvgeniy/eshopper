<?php if(!empty($items)) : ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
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
                    <td><span data-id="<?= $item->product_id ?>" class="glyphicon glyphicon-remove text-danger del-item"></span></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="4">Итого</td>
                    <td></td>
                </tr>
            <tr>
                <td colspan="4">На сумму</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <h3>Корзина пуста</h3>
<?php endif; ?>
