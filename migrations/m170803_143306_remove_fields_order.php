<?php

use yii\db\Migration;

class m170803_143306_remove_fields_order extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('order', 'qty');
        $this->dropColumn('order', 'sum');
    }

    public function safeDown()
    {
        $this->addColumn('order', 'qty', $this->integer()->notNull());
        $this->addColumn('order', 'sum', $this->float()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_143306_remove_fields_order cannot be reverted.\n";

        return false;
    }
    */
}
