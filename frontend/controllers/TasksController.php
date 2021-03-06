<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
       $tasks = Tasks::find()
           ->where(['status_id' => '1'])
           ->orderBy(['creation_date' => SORT_DESC])
           ->all();

       $this->view->title = "TaskForce";
        return $this->render('index', ['tasks' => $tasks]);
    }
}