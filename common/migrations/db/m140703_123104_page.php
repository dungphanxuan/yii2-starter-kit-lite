<?php

use yii\db\Migration;
use yii\db\Schema;

class m140703_123104_page extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id'         => $this->primaryKey(),
            'slug'       => $this->string(2048)->notNull(),
            'title'      => $this->string(512)->notNull(),
            'body'       => $this->text()->notNull(),
            'view'       => $this->string(),
            'status'     => $this->smallInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-page_status', '{{%page}}', 'status');
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}
