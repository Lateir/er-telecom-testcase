<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string|null $full_name
 * @property int $post
 * @property string $birth_date
 * @property string $employment_date
 * @property string $avatar_url
 * @property string|null $end_date
 * @property string $phone_number
 * @property string $email
 */
class EmployeesModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'post', 'employment_date'], 'required'],
            [['post'], 'integer'],
            [['birth_date', 'employment_date', 'end_date'], 'safe'],
            [['full_name', 'phone_number', 'email', 'avatar_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'post' => 'Post',
            'avatar_url' => 'Avatar URL',
            'birth_date' => 'Birth Date',
            'employment_date' => 'Employment Date',
            'end_date' => 'End Date',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
        ];
    }

    /**
     * Метод для постраничной выдачи работников с поиском
     *
     * @param int $page Страница
     * @param bool $search Данные для поиска
     * @param int $pageSize Количесиво строк на 1 страницу
     * @return array
     */
    public static function getEmployees(int $page = 1, $search = false, int $pageSize = 50): array
    {
        $query = self::find()
            ->where(['id' => intval($search)])
            ->orWhere("LOWER(full_name) LIKE LOWER('%$search%')")
            ->orWhere("phone_number LIKE '%$search%'")
            ->orWhere("email LIKE '%$search%'")
            ->orderBy('id ASC')
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize);

        return [
            'totalCount' => $query->count(), // Количество страниц
            'data' => $query->all() // Сами данные
        ];
    }

    /**
     * Метод для получения сотрудника по ID
     *
     * @param int $id Идентификатор сотрудника
     * @return array|ActiveRecord[]
     */
    public static function getEmployee(int $id)
    {
        return self::find()->where(['id' => $id])->all() ;
    }

    /**
     * Метод для получения статистики по дате
     *
     * @param $date
     * @return array|ActiveRecord[]
     */
    public static function getStats($date)
    {
        return self::find()
            ->select(['post', 'COUNT(*) as count'])
            ->where(['<=', 'employment_date', $date])
            ->andWhere(['or', ['end_date' => null], ['>', 'end_date', $date]])
            ->groupBy('post')
            ->asArray()
            ->all();
    }

    /**
     * Метод для редактирования данных сотрудника.
     *
     * @param int $id Идентификатор сотрудника
     * @param array $data Массив данных для обновления.
     * @return bool Возвращает true в случае успешного обновления или false в противном случае.
     */
    public static function updateEmployee($id, $data)
    {
        $employee = self::findOne($id);

        if (!$employee) {
            return false; // Сотрудник не найден
        }

        $employee->attributes = $data;

        return $employee->save();
    }

    /**
     * Метод для добавления нового сотрудника.
     *
     * @param array $data Массив данных для нового сотрудника.
     * @return true|array Возвращает true в случае успешного добавления или массив с ошибкой в противном случае.
     */
    public static function addEmployee($data)
    {
        $employee = new self();
        $employee->attributes = $data;
        return $employee->save() ? true : $employee->getErrors();
    }
}