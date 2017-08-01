<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m170728_102707_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'content' => $this->text(),
            'price' => $this->float()->notNull(),
            'keywords' => $this->string()->defaultValue('NULL'),
            'description' => $this->string()->defaultValue('NULL'),
            'img' => $this->string()->notNull(),
            'new' => $this->boolean()->defaultValue(0)->notNull(),
            'hit' => $this->boolean()->defaultValue(0)->notNull(),
            'sale' => $this->boolean()->defaultValue(0)->notNull(),
        ]);

        $this->addForeignKey('product_category_id', 'product', 'category_id', 'category', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
