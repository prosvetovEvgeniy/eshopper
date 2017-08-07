<?php

use yii\db\Migration;
use yii\db\Query;

class m170805_172806_update_order_table extends Migration
{
    public function safeUp()
    {
        //меняем тип поля status с enum на boolean
        $query = new Query();
        $statuses = $query->select('id', 'status')->from('order')->all();

        $this->alterColumn('order', 'status', $this->boolean()->notNull()->defaultValue(0));

        foreach ($statuses as $status){
            $this->update('order',  ['status' => 0], "id = {$status['id']}");
        }

        //добавляем внешний ключ customer_id
        $this->addColumn('order','customer_id', $this->integer());
        $this->addForeignKey('order_customer_id', 'order', 'customer_id', 'customer','id');

        $orderEmails = $query->select(['id', 'email'])->from('order')->all();

        $cutstomerEmails = $query->select(['id', 'email'])->from('customer')->all();

        //заполняем значения costomer id
        for($i = 0; $i < count($orderEmails); $i++){
            for($j = 0; $j < count($cutstomerEmails); $j++){
                if($orderEmails[$i]['email'] == $cutstomerEmails[$j]['email']){
                    $this->update('order',  ['customer_id' => $cutstomerEmails[$j]['id']], "id = {$orderEmails[$i]['id']}");
                    break;
                }
            }
        }

        $this->dropColumn('order', 'name');
        $this->dropColumn('order', 'email');
        $this->dropColumn('order', 'phone');
        $this->dropColumn('order', 'address');
    }

    public function safeDown()
    {
        $this->addColumn('order', 'name',$this->string()->notNull());
        $this->addColumn('order', 'email',$this->string()->notNull());
        $this->addColumn('order', 'phone',$this->string()->notNull());
        $this->addColumn('order', 'address',$this->string()->notNull());

        $this->alterColumn('order', 'status', "ENUM('0', '1') NOT NULL DEFAULT '0'");
        $query = new Query();
        $statuses = $query->select('id', 'status')->from('order')->all();

        foreach ($statuses as $status){
            $this->update('order',  ['status' => '0'], "id = {$status['id']}");
        }

        $query = new Query();
        $orderData= $query->select(['id', 'customer_id'])->from('order')->all();

        $cutstomerData = $query->select(['id', 'name', 'email', 'phone', 'address'])->from('customer')->all();

        for($i = 0; $i < count($orderData); $i++){
            for($j = 0; $j < count($cutstomerData); $j++){
                if($orderData[$i]['customer_id'] == $cutstomerData[$j]['id']){
                    $this->update('order',  ['name' => $cutstomerData[$j]['name']], "id = {$orderData[$i]['id']}");
                    $this->update('order',  ['email' => $cutstomerData[$j]['email']], "id = {$orderData[$i]['id']}");
                    $this->update('order',  ['phone' => $cutstomerData[$j]['phone']], "id = {$orderData[$i]['id']}");
                    $this->update('order',  ['address' => $cutstomerData[$j]['address']], "id = {$orderData[$i]['id']}");
                    break;
                }
            }
        }
        $this->dropForeignKey('order_customer_id', 'order');
        $this->dropColumn('order', 'customer_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_172806_update_order_table cannot be reverted.\n";

        return false;
    }
    */
}
