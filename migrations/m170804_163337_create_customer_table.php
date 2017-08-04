<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Handles the creation of table `customer`.
 */
class m170804_163337_create_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
        $this->createTable('customer',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
        ]);

        $query = new Query();
        $cutstomers = $query->select(['name', 'email', 'phone', 'address'])->from('order')->all();

        $N = count($cutstomers);

        //делаем полный перебор
        for($i = 0; $i < $N; $i++){

            //если i-ая запись не последняя и не null
            if($cutstomers[$i] != NULL && $i != $N - 1) {

                $flag = true; //показывает была ли найдена запись с таким же email в массиве

                //начинаем обход со следущего массива после текущего
                for ($j = $i + 1; $j < $N; $j++) {
                    //
                    if ($cutstomers[$i]['email'] == $cutstomers[$j]['email']) {
                        $lastCustomer = $cutstomers[$j]; //запоминаем ассоциативный массив
                        $cutstomers[$j] = NULL; //помечаем как пройденное поле
                        $flag = false; //показываем, что была найдена такая же запись
                    }
                    //если элемент в массиве последний и похожих записей не было запоминаем его
                    if($j == $N - 1){
                        if($flag){
                            $lastCustomer = $cutstomers[$i];
                        }
                    }
                }
                $this->insert('customer', [ //вставляем данные в таблицу

                    'name' => $lastCustomer['name'],
                    'email' => $lastCustomer['email'],
                    'phone' => $lastCustomer['phone'],
                    'address' => $lastCustomer['address'],

                ]);
            }
            //если запись последняя и уникальная то вставляем данные в таблицу
            if($i == $N - 1 && $cutstomers[$i] != NULL){
                $lastCustomer = $cutstomers[$i];
                $this->insert('customer', [

                    'name' => $lastCustomer['name'],
                    'email' => $lastCustomer['email'],
                    'phone' => $lastCustomer['phone'],
                    'address' => $lastCustomer['address'],

                ]);
            }
        }
    }
    
    public function down()
    {
        $this->dropTable('customer');
    }
}
