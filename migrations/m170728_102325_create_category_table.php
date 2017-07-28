<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170728_102325_create_category_table extends Migration
{

    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'keywords' => $this->string()->defaultValue('NULL'),
            'description' => $this->string()->defaultValue('NULL')
        ]);
        $this->addForeignKey('category_parent_id', 'category', 'parent_id', 'category', 'id');
    }

    public function down()
    {
        $this->dropTable('category');
    }
}
