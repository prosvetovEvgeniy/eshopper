<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170726_130945_create_user_table extends Migration
{

    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string()->defaultValue('NULL')
        ]);
    }
    
    public function down()
    {
        $this->dropTable('user');
    }
}
