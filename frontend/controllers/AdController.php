<?php

namespace frontend\controllers;

use Yii;
use common\models\Ad;
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
    
    public function loadRelation($mainModel, $relationName, $relatedModelClassName, $data)
    {
        $loaded = true;
        $models = [];
        $stub = new $relatedModelClassName;
        
        foreach ($data[$stub->formName()] as $modelData) {
            if (isset($modelData['id'])) {
                $model = $relatedModelClassName::findOne($modelData['id']);
                
                if (!$model) {
                    unset($modelData['id']);
                    $model = new $relatedModelClassName();
                }
            } else {
                $model = new $relatedModelClassName();
            }
            
            $currentModelLoaded = $model->load([$stub->formName() => $modelData]);
            if (!$currentModelLoaded) $loaded = false;
            
            $models[] = $model;
        }
        $mainModel->populateRelation($relationName, $models);
        unset($stub);
        
        return $loaded;
    }
    
    public function loadModelWithRelations($model, $data)
    {
        $modelLoaded = true;
        do {
            $loaded = $model->load($data);
            $modelLoaded = $loaded && $modelLoaded;
            if (!$modelLoaded) break;
            
            $loaded = $this->loadRelation($model, 'adJobLocations', AdJobLocation::className(), $data);
            $modelLoaded = $loaded && $modelLoaded;
            
            $loaded = $this->loadRelation($model, 'adNewspapers', AdNewspaper::className(), $data);
            $modelLoaded = $loaded && $modelLoaded;
            
            $stub = new AdNewspaperPlacementDate();
            foreach ($model->adNewspapers as $i => $adNewspaper) {
                $loaded = $this->loadRelation($adNewspaper, 'adNewspaperPlacementDates', AdNewspaperPlacementDate::className(),
                    [$stub->formName() => $data[$stub->formName()][$i]]);
                $modelLoaded = $loaded && $modelLoaded;
            }
        }
        while (false);
        
        return $modelLoaded;
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
        if ($this->loadModelWithRelations($model, $post)) {
            
            $this->dump($model);
            
            $saved = $model->save();
            
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
