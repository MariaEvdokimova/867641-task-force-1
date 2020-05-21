<?php


namespace frontend\controllers;


use frontend\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex() {
        $users = Users::find()
            ->where(['role_id' => '2'])
            ->orderBy(['creation_date' => SORT_DESC])
            ->all();

        $this->view->title = "TaskForce";
        return $this->render('index', ['users' => $users]);
    }
}