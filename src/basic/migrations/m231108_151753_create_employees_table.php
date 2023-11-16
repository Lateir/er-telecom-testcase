<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees}}`.
 */
class m231108_151753_create_employees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employees}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'post' => $this->integer()->notNull(),
            'birth_date' => $this->date()->null(),
            'phone_number' => $this->string()->null(),
            'email' => $this->string()->null(),
            'avatar_url' => $this->string()->null(),
            'employment_date' => $this->date()->notNull(),
            'end_date' => $this->date()->null(),
        ]);
        $this->execute("ALTER TABLE `employees` MODIFY `full_name` VARCHAR(255) CHARSET utf8mb4");
        $this->execute("ALTER TABLE `employees` MODIFY `phone_number` VARCHAR(255) CHARSET utf8mb4");
        $this->execute("ALTER TABLE `employees` MODIFY `email` VARCHAR(255) CHARSET utf8mb4");
        $this->execute("ALTER TABLE `employees` MODIFY `avatar_url` VARCHAR(255) CHARSET utf8mb4");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employees}}');
    }
}
