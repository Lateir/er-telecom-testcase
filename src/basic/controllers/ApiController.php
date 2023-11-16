<?php
namespace app\controllers;

use app\models\EmployeesModel;
use app\models\PostModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\filters\Cors;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\EmployeesModel';

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->actionGetEmployees();
    }

    public function actionGetPosts()
    {
        return PostModel::find()->all();
    }

    public function actionGetEmployees($page = 1, $search = '', $pageSize = 50)
    {

        $modelResult = EmployeesModel::getEmployees($page, $search, $pageSize);

        return [
            'page' => (int)$page, // Текущая страница
            'pageCount' => ceil($modelResult['totalCount'] / $pageSize), // Общее количество страниц
            'pageSize' => (int)$pageSize, // Размер страницы
            'totalCount' => (int)$modelResult['totalCount'], // Общее количество записей
            'employees' => $modelResult['data'], // Данные работников для текущей страницы
        ];
    }

    public function actionGetEmployee($id)
    {
        $modelResult = EmployeesModel::getEmployee($id);
        return count($modelResult) > 0 ? $modelResult[0] : ['success' => false, 'message' => 'Сотрудник не найден'];
    }

    public function actionGetStats($date)
    {
        // Проверяем, что дата передана и имеет корректный формат
        try {
            $date = Yii::$app->formatter->asDate($date, 'yyyy-MM-dd');
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Неверный формат даты'];
        }


        $modelResult = EmployeesModel::getStats($date);
        return $modelResult;
    }

    public function actionUpdateEmployee($id)
    {
        $data = Yii::$app->request->post();

        $result = EmployeesModel::updateEmployee($id, $data);

        if ($result) {
            return ['success' => true, 'message' => 'Данные сотрудника успешно обновлены.'];
        } else {
            return ['success' => false, 'message' => 'Не удалось найти или обновить данные сотрудника.'];
        }
    }

    public function actionAddEmployee()
    {
        $data = Yii::$app->request->post();

        $result = EmployeesModel::addEmployee($data);

        if ($result === true) {
            return ['success' => true, 'message' => 'Новый сотрудник успешно добавлен.'];
        } else {
            return ['success' => false, 'message' => $result];
        }
    }
}