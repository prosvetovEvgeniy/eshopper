<?php

use yii\db\Migration;

class m170814_093259_rename_customer_table extends Migration
{
    public function safeUp()
    {
        $this->dropTable('user');
        $this->renameTable('customer','user');

        $this->dropForeignKey('order_customer_id', 'order');
        $this->renameColumn('order','customer_id','user_id');
        $this->addForeignKey('order_user_id', 'order','user_id','user','id');

        $this->dropForeignKey('cart_customer_id', 'cart');
        $this->renameColumn('cart','customer_id','user_id');
        $this->addForeignKey('cart_user_id', 'cart','user_id','user','id');
    }

    public function safeDown()
    {
        $this->renameTable('user', 'customer');

        $this->dropForeignKey('order_user_id', 'order');
        $this->renameColumn('order','user_id','customer_id');
        $this->addForeignKey('order_customer_id', 'order','customer_id','customer','id');

        $this->dropForeignKey('cart_user_id', 'cart');
        $this->renameColumn('cart','user_id','customer_id');
        $this->addForeignKey('cart_customer_id', 'cart','customer_id','customer','id');

        $this->createTable('user',[
            'id' => $this->primaryKey(),
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170814_093259_rename_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
