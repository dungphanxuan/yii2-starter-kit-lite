<?php

use yii\db\Migration;

/**
 * Handles the creation of table `app`.
 */
class m170226_021025_create_app_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('app', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('app');
    }
}
