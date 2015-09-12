<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Ad;
use common\models\AdJobLocation;
use common\models\AdNewspaper;
use common\models\AdNewspaperPlacementDate;
use frontend\models\AdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function dump($model)
    {
        var_dump($_POST);
        
        var_dump($model->attributes);
        
        foreach ($model->adJobLocations as $adJobLocation) {
            var_dump($adJobLocation->attributes);
        }
        
        foreach ($model->adNewspapers as $adNewspaper) {
            var_dump($adNewspaper->attributes);
            
            foreach ($adNewspaper->adNewspaperPlacementDates as $date) {
                var_dump($date->attributes);
            }
        }
        
        die;
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ad();
        
        $post = Yii::$app->request->post();
        if ($model->loadWithRelations($post) && $model->validateWithRelations()) {
            
            $saved = $model->saveWithRelations();
            
            if ($saved) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->loadWithRelations($post) && $model->validateWithRelations()) {
            
            $saved = $model->saveWithRelations();
            
            if ($saved) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
