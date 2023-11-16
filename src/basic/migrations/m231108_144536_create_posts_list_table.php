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
            'name' => $this->string()->notNull(),
        ]);
        $this->execute("ALTER TABLE `posts_list` MODIFY `name` VARCHAR(255) CHARSET utf8mb4");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_list}}');
    }
}
