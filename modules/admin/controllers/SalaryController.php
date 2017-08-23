<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 17.08.2017
 * Time: 14:47
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\DateForm;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderItems;
use Faker\Provider\zh_TW\DateTime;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use DatePeriod;
use Yii;
use DateInterval;

class SalaryController extends Controller
{
    public function actionView(){

        $orders = Order::find()->orderBy('created_at')->all();
        $model = new DateForm();

        //получаем массив диапозонов дат по месяцам
        $months = $this->getDateRange($orders);

        //формируем массив с годами для поля year модели DateForm
        $years = [];
        foreach ($months as $key => $date){
            $years[] = $key;
        }

        //если переключились на другой год в виде view меняем месяца в поле month
        if(Yii::$app->request->isAjax){
            $year = Yii::$app->request->post('year');

            $option = ""; //содержит в себе теги option

            //проходимся по всему массиву для текущего года
            foreach ($months[$year] as $month){
                $option .= '<option value="'. $this->getMonthIndex($month) .'">' . $month . '</option>';
            }

            return $option; //возращаем ответ
        }

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            $currentYear = $years[$model->year];
            $listOrders = $this->getOrdersInRange($currentYear, $model->month);

            return $this->render('view', ['model' => $model, 'years' => $years, 'months' => $months[$currentYear], 'orders' => $listOrders]);

        }

        return $this->render('view', ['model' => $model, 'years' => $years, 'months' => $months[$years[0]]]);
    }

    //возращает миссива вида :[[номер года] => ['название месяца1', 'название месяца2','название месяца3',...] ...]
    private function getDateRange($orders){

        $start    = new \DateTime($orders[0]->created_at); //дата первой продажи
        $end      = new \DateTime($orders[count($orders) - 1]->created_at); //дата последней продажи

        //содержит количество дней в определенном месяце
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $end->format('n'), $end->format('Y'));

        //разница между датой последней продажи и количеством дней в месяце этой последней продажи
        $difference = (string) ($daysInMonth - (int) $end->format('d'));

        //округляем дату последней продажи, чтобы получился полный месяц, иначе DateInterval('P1M') не будет учитывать эту дату
        $end->modify("+" . $difference . " day");

        //разбиваем интервал между двумя датами по месяцам
        $period = new \DatePeriod($start, new DateInterval('P1M'), $end);

        $months = [];

        //заполняем массив months :[[номер года] => ['название месяца1', 'название месяца2','название месяца3',...] ...]
        foreach ($period as $date) {
            $monthName = $this->getMonthName($date->format('n'));
            $months[$date->format('Y')][$this->getMonthIndex($monthName)] = $monthName;
        }
        return $months;
    }

    private function getOrdersInRange($currentYear, $month){

        if($month < 12){

            $dateFrom = new \DateTime($currentYear . '-' . $month);
            $dateTo = new \DateTime(($currentYear . '-' . (string) ($month + 1)));

        }
        else{
            $dateFrom = new \DateTime($currentYear . '-' . $month);
            $dateTo = new \DateTime(((string) ($currentYear + 1) . '-1'));
        }

        $listOrders = Order::find()->where("created_at >= '{$dateFrom->format('Y-m')}' AND created_at < '{$dateTo->format('Y-m')}'")->all();

        return $listOrders;
    }

    //возращает название месяца
    private function getMonthName($number){
        $monthName = array(
            1 => 'январь', 2 => 'февраль', 3 => 'март', 4 => 'апрель',
            5 => 'май', 6 => 'июнь', 7 => 'июль', 8 => 'август',
            9 => 'сентябрь', 10 => 'октябрь', 11 => 'ноябрь', 12 => 'декабрь'
        );

        return $monthName[$number];
    }
    //возращает номер месяца
    private function getMonthIndex($name){
        $monthIndexes = array(
            'январь' => 1, 'февраль' => 2, 'март' => 3, 'апрель' => 4,
            'май' => 5, 'июнь' => 6, 'июль' => 7, 'август' => 8,
            'сентябрь' => 9, 'октябрь' => 10, 'ноябрь' => 11, 'декабрь' => 12
        );

        return $monthIndexes[$name];
    }
}