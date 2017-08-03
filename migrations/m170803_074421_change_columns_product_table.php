<?php

use yii\db\Migration;
use app\models\Product;

class m170803_074421_change_columns_product_table extends Migration
{
    public function safeUp()
    {
        $previousProducts = Product::find()->all();

        $this->alterColumn('product', 'new', $this->boolean()->notNull()->defaultValue(0));
        $this->alterColumn('product', 'sale', $this->boolean()->notNull()->defaultValue(0));
        $this->alterColumn('product', 'hit', $this->boolean()->notNull()->defaultValue(0));

        foreach($previousProducts as $product){
            $this->update('product',  ['new' => $product->new], "id = {$product->id}");
            $this->update('product',  ['hit' => $product->hit], "id = {$product->id}");
            $this->update('product',  ['sale' => $product->sale], "id = {$product->id}");
        }
    }

    public function safeDown()
    {
        $previousProducts = Product::find()->all();

        $this->alterColumn('product', 'new', "ENUM('0', '1') NOT NULL DEFAULT '0'");
        $this->alterColumn('product', 'sale', "ENUM('0', '1') NOT NULL DEFAULT '0'");
        $this->alterColumn('product', 'hit', "ENUM('0', '1') NOT NULL DEFAULT '0'");

        foreach($previousProducts as $product){
            $this->update('product',  ['new' => $product->new], "id = {$product->id}");
            $this->update('product',  ['hit' => $product->hit], "id = {$product->id}");
            $this->update('product',  ['sale' => $product->sale], "id = {$product->id}");
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_074421_change_columns_product_table cannot be reverted.\n";

        return false;
    }
    */
}
