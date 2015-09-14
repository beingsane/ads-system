<?php

namespace backend\controllers;

use Yii;
use common\models\ExportItem;
use backend\models\ExportItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * ExportController implements the CRUD actions for ExportItem model.
 */
class ExportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-date-item' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExportItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        
        $searchModel = new ExportItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Deletes AdPlacementDate item from existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteDateItem($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::previous());
    }
    
    public function actionExport()
    {
        $searchModel = new ExportItemSearch();
        $modelsForExport = $searchModel->export(Yii::$app->request->queryParams);
        
        
        $templateFile = '@backend/template/ads_template.xml';
        $attachmentName = 'export-'.date('Y-m-d-H-i-s');
        $content = $this->renderPartial($templateFile, [
            'models' => $modelsForExport,
        ]);
        
        if ($content) {
            return Yii::$app->response->sendContentAsFile($content, $attachmentName.'.xml');
        }
        
        return Yii::t('app', 'An error occurred while exporting file');
    }

    /**
     * Finds the ExportItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExportItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExportItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
