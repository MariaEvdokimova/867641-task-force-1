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

        foreach ($users as $user) {
            $user['creation_date'] = \Yii::$app->formatter->format($user['creation_date'], 'relativeTime');
        }

        $this->view->title = "TaskForce";
        return $this->render('index', ['users' => $users]);
    }
}