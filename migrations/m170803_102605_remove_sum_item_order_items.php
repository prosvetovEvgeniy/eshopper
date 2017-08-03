<?php

use yii\db\Migration;

class m170803_102605_remove_sum_item_order_items extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('order_items', 'sum_item');
    }

    public function safeDown()
    {
        $this->addColumn('order_items', 'sum_item', $this->float()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_102605_remove_sum_item_order_items cannot be reverted.\n";

        return false;
    }
    */
}
