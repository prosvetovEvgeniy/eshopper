<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_items`.
 */
class m170728_103431_create_order_items_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_items', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'qty_item' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('order_items_order_id', 'order_items', 'order_id', 'order', 'id');
        $this->addForeignKey('order_items_product_id', 'order_items', 'product_id', 'product', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_items');
    }
}
