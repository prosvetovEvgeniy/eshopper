<?php

use yii\db\Migration;

class m170812_073819_change_customer_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('customer','password', $this->string()->notNull());
        $this->alterColumn('customer', 'phone', $this->string());
        $this->alterColumn('customer', 'address', $this->string());
    }

    public function safeDown()
    {
        $this->alterColumn('customer', 'phone', $this->string()->notNull());
        $this->alterColumn('customer', 'address', $this->string()->notNull());
        $this->dropColumn('customer', 'password');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170812_073819_change_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
