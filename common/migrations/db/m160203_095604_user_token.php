<?php

use yii\db\Migration;
use yii\db\Schema;

class m160203_095604_user_token extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_token}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'type'       => $this->string()->notNull(),
            'token'      => $this->string(40)->notNull(),
            'expire_at'  => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        //Index
        $this->createIndex('idx-token_expire', '{{%user_token}}', 'expire_at');
        $this->createIndex('idx-token_type', '{{%user_token}}', 'type');
        $this->createIndex('idx-token_value', '{{%user_token}}', 'token');

        $this->addForeignKey('fk_token_user', '{{%user_token}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%user_token}}');
        $this->dropForeignKey('fk_token_user', '{{%user_token}}');
    }
}
