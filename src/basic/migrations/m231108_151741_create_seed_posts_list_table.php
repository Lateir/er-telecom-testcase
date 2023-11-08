<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seed_posts_list}}`.
 */
class m231108_151741_create_seed_posts_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seed_posts_list}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seed_posts_list}}');
    }
}
