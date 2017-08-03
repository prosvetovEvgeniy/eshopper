<?php

use yii\db\Migration;

class m170803_094514_remove_img_product_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('product', 'img');
        $this->addColumn('product', 'deleted', $this->boolean()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('product', 'deleted');
        $this->addColumn('product', 'img', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_094514_remove_img_product_table cannot be reverted.\n";

        return false;
    }
    */
}
