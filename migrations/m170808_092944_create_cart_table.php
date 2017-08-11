<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170808_092944_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
   public function up()
    {
        $this->createTable('cart', [
            'id' => $this->string('36')->notNull(),
            'customer_id' => $this->integer(),
        ]);
        $this->addPrimaryKey('cart_id', 'cart', 'id');
        $this->addForeignKey('cart_customer_id', 'cart', 'customer_id','customer','id');
    }


    public function down()
    {
        $this->dropForeignKey('cart_customer_id', 'cart');
        $this->dropTable('cart');
    }
}
