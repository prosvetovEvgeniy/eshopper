<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart_items`.
 */
class m170808_094020_create_cart_items_table extends Migration
{
    public function up()
    {
        $this->createTable('cart_items', [
            'cart_id' => $this->string('36')->notNull(),
            'product_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull()->defaultValue(1),
            'PRIMARY KEY (`cart_id`, `product_id`)',
        ]);
        $this->addForeignKey('cart_items_cart_id', 'cart_items', 'cart_id', 'cart','id');
        $this->addForeignKey('cart_items_product_id', 'cart_items', 'product_id', 'product', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('cart_items_cart_id','cart_items');
        $this->dropForeignKey('cart_items_product_id','cart_items');
        $this->dropTable('cart_items');
    }
}
