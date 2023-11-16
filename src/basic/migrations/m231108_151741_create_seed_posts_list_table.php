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
        $posts = ['специалист', 'эксперт', 'супервайзер', 'руководитель'];
        foreach ($posts as $post) {
            $this->insert('{{%posts_list}}', [
                'name' => $post
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
