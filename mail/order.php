
<div class="container">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item) : ?>
                    <tr>
                        <td><?= $item->product->name; ?></td>
                        <td><?= $item->amount; ?></td>
                        <td><?= $item->product->price; ?></td>
                        <td><?= $item->product->price * $item->amount ?></td>
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
    <div>
        <?php if (\Yii::$app->user->isGuest) : ?>
            <h3>Ваш пароль для входа на сайт:</h3>
            <h2><?= $password ?></h2>
        <?php endif; ?>
    </div>
</div>