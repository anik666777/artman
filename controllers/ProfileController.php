<?php

namespace app\controllers;


use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController  extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'toggle-status' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCabinet()
    {
        $model = $this->findModelUser();
        return $this->render('cabinet', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionToggleStatus() {
        $model = $this->findModelUser();
        $model->is_online = $model->isOnline() ? User::IS_OFFLINE : User::IS_ONLINE;
        $model->save();
        return $this->redirect(['cabinet']);
    }

    protected function findModelUser()
    {
        if (($model = User::findOne(['id' => Yii::$app->user->id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}