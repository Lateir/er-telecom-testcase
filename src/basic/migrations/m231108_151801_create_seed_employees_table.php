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
        $names = array("Иван", "Александр", "Мария", "Екатерина", "Артем", "София", "Максим", "Анна", "Дмитрий", "Елена");
        $surnames = array("Иванов", "Петров", "Смирнов", "Кузнецов", "Соколов", "Попов", "Лебедев", "Козлов", "Новиков", "Морозов");
        $patronyms = array("Иванович", "Петрович", "Александрович", "Дмитриевич", "Андреевич", "Сергеевич", "Николаевич", "Владимирович", "Михайлович", "Егорович");

        for ($i = 0; $i < 1000; $i++) {


            $this->insert('{{%employees}}', [
                'full_name' => $names[array_rand($names)] . " " . $surnames[array_rand($surnames)] . " " . $patronyms[array_rand($patronyms)],
                'post' => rand(1, 4),
                'birth_date' => date('Y-m-d', rand(944192276, 974192276)),
                'employment_date' => date('Y-m-d', rand(1242185876, 1542185876)),
                'end_date' => $this->getEndDate(),
                'phone_number' => 89000000000 + rand(0, 999999999),
                'email' => rand(0, 99999).'@test.test',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    private function getEndDate() {
        return rand(0, 1) === 1 ? date('Y-m-d', rand(1542185876, 1699970464)) : null;
    }
}
