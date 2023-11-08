<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_list}}`.
 */
class m231108_144536_create_posts_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_list}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_list}}');
    }
}
