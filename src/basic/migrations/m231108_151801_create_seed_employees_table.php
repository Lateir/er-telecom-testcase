<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seed_employees}}`.
 */
class m231108_151801_create_seed_employees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seed_employees}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seed_employees}}');
    }
}
