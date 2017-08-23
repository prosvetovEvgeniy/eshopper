<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\admin\models\OrderItems;
?>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

    <?= $form->field($model, 'year')->dropDownList($years,
        ['onchange' =>
         "$.ajax({
              url: 'view',
              type: 'POST',
              data: {year: $(this).find('option:selected').text()},
              success: function (res) {
                  $('#dateform-month').html(res).attr('disabled', false);
                  //console.log(res);
              },
              error: function (e) {
                  console.log(e);
                  alert('Error');
              }
	    })"
        ]
    ) ?>

    <?= $form->field($model, 'month')->dropDownList($months) ?>

    <div class="form-group">
        <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
    <?php if(!empty($orders)): ?>

        <?php
            $days = [];

            $start    = new \DateTime($orders[0]->created_at); //дата первой продажи за месяц
            $end      = new \DateTime($orders[count($orders) - 1]->created_at); //дата последней продажи за месяц

            $end->modify("+1 day");

            $period = new \DatePeriod($start, new DateInterval('P1D'), $end);

            foreach ($period as $date) {
                $days[] = $date->format('Y.m.j');
            }
        ?>

        <?php
        $counter = 0;       //счетчик, используется для добавление в шапку таблицы названиме даты
        $managerSalary = 0; //итоговая зарплата менеджера
        $totalSum = 0;      //итоговая сумма товара за месяц
        $totalAmount = 0;   //итоговое количество товара за месяц
        $isFirstDay = true; //флаг для того, чтобы узнать первый ли день
        $amountPerDay = 0;  //количество товара, которое продали за день
        $sumPerDay = 0;     //итоговая стоимость проданного товара за день
        $salaryPerDay = 0;  //зарплата менеджера за день

        //проходимся по каждому заказу
        foreach ($orders as $order){
            $date = new \DateTime($order->created_at); //дата текущей продажи

            //если день поменялся то строим новую таблцу
            if($days[$counter] == $date->format('Y.m.j')){
                $counter++; //увеличиваем счетчик

                //если день первый то не добавляем теги закрытия таблицы
                if($isFirstDay) {
                    $isFirstDay = false;
                }
                else{ //если день не первый добавляем теги закрытие таблицы при смене дня
                    ?>
                    <tr class="bg-warning">
                        <td colspan="2" class="text-center">Итог</td>
                        <td><?= $amountPerDay ?></td>
                        <td ><?= $sumPerDay ?></td>
                        <td><?= $salaryPerDay ?></td>
                    </tr>
                    </tbody>
                    </table>
                <?php }
                $salaryPerDay = 0;
                $amountPerDay = $order->amount;
                $sumPerDay = $order->totalSum;
                $totalSum += $order->totalSum;
                $totalAmount += $order->amount;
                //выводим шапку таблицы
                ?>

                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-info">
                        <th colspan="5" class="text-center"><?= $date->format('Y.m.d'); ?></th>
                    </tr>
                    <tr>
                        <th>Ид продажи</th>
                        <th>Название товара</th>
                        <th>Количество</th>
                        <th>Общая сумма</th>
                        <th>Сумма вознаграждения</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //проходимся по каждому элементу, в OrderItems для текущего заказа и добавляем как строку в html таблицу
                    $orderItems = OrderItems::find()->where(['order_id' => $order->id])->all();
                    foreach ($orderItems as $item) {
                        $salary = 0; //вспомогательная переменная для расчета зарплаты
                        $percent; //строка, которая содержит количество процетов надбавки
                        if($item->price > 1000){
                            $salary += 50 + ($item->price * 0.05);
                            $percent = '5%';
                        }
                        else if($item->price > 500){
                            $salary += 50 + ($item->price * 0.02);
                            $percent = '2%';
                        }
                        else {
                            $salary += 50;
                            $percent = '0%';
                        }
                        $salary = round($item->qty_item * $salary);
                        $salaryPerDay += $salary; //считаем зарплату за день
                        $managerSalary += $salary;//считаем итоговую зарплату
                        //выводим строку
                        ?>
                        <tr>
                            <th scope="row"><?= $order->id ?></th>
                            <td><?= $item->name ?></td>
                            <td><?= $item->qty_item ?></td>
                            <td><?= $item->qty_item*$item->price ?></td>
                            <td>+<?= $salary ?> ( <?= $percent?> &#8657;)</td>
                        </tr>
                    <?php } ?>
            <?php }
            else {
                //аналогичные действия как и в первом блоке кода, только не выводится заголовок таблицы
                $amountPerDay += $order->amount;
                $sumPerDay += $order->totalSum;
                $totalSum += $order->totalSum;
                $totalAmount += $order->amount;

                $orderItems = OrderItems::find()->where(['order_id' => $order->id])->all();
                foreach ($orderItems as $item) {
                    $salary = 0;
                    $percent;
                    if($item->price > 1000){
                        $salary += 50 + ($item->price * 0.05);
                        $percent = '5%';
                    }
                    else if($item->price > 500){
                        $salary += 50 + ($item->price * 0.02);
                        $percent = '2%';
                    }
                    else {
                        $salary += 50;
                        $percent = '0%';
                    }
                    $salary = round($item->qty_item * $salary);
                    $salaryPerDay += $salary;
                    $managerSalary += $salary;
                    ?>
                    <tr>
                        <th scope="row"><?= $order->id ?></th>
                        <td><?= $item->name ?></td>
                        <td><?= $item->qty_item ?></td>
                        <td><?= $item->qty_item*$item->price ?></td>
                        <td>+<?= $salary ?>  ( <?= $percent?> &#8657;)</td>
                    </tr>
                <?php } ?>
            <?php } ?>

        <?php }
        ?>
            <tr class="bg-warning">
                <td colspan="2" class="text-center">Итог</td>
                <td><?= $amountPerDay ?></td>
                <td ><?= $sumPerDay ?></td>
                <td><?= $salaryPerDay ?></td>
            </tr>
            </tbody>
            </table>
        <br><br><br>

            <table class="table table-bordered">
                <thead>
                <tr class="bg-info">
                    <th colspan="3" class="text-center">Итоговые результаты</th>
                </tr>
                <tr>
                    <th class="text-center">Количество проданного товара</th>
                    <th class="text-center">Итоговая стоимость</th>
                    <th class="text-center">Зарплата менеджера</th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-warning">
                    <td class="text-center"><?= $totalAmount ?></td>
                    <td class="text-center"><?= $totalSum ?></td>

                    <td class="text-center"><?= $managerSalary ?></td>
                </tr>

                <?php
                if($managerSalary > 90000){
                    $managerSalary = round($managerSalary + ($totalSum * 0.01));
                }
                elseif ($managerSalary < 60000 && $managerSalary > 5000){
                    $managerSalary -= 5000;
                }
                ?>

                <tr class="bg-success">
                    <td class="text-center" colspan="2">C надбавками (с вычетом)</td>

                    <td class="text-center"><?= $managerSalary ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>

        </div>
    </div>
</div>


