<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->can('admin')) {
            throw new NotFoundHttpException('Page not found.');
        }
        
        return $this->render('index');
    }

    public function actionError()
    {
        if (!Yii::$app->user->can('admin')) {
            $this->layout = 'user_layout';
        }
        
        $action = Yii::createObject(['class' => 'yii\web\ErrorAction'], ['error', $this]);
        return $action->runWithParams([]);
    }
}
