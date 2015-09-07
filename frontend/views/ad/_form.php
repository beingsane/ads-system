<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-like-horizontal'],
    ]); ?>
    
        <div class="row">
            <div class="col-md-2">
                <label class="control-label"><?= Yii::t('app', 'Job') ?></label>
            </div>
            <div class="col-md-10">
                <?= $form->field($model, 'job_name')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-2">
                <label class="control-label"><?= Yii::t('app', 'Job Location') ?></label>
                
                <div class="text-right m-t-sm m-b-lg">
                    <button type="button" id="add-location-button" class="btn btn-primary"><?= Yii::t('app', 'Add location') ?></button>
                </div>
            </div>
            <div class="col-md-10">
                <div id="ad-form-job-locations-container">
                    <?php foreach ($model->adJobLocations as $jobLocation) { ?>
                        <?= $this->render('__form_job_location', ['form' => $form, 'model' => $jobLocation]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-2">
                <label class="control-label"><?= Yii::t('app', 'Newspaper Edition') ?></label>
                
                <div class="text-right m-t-sm m-b-lg">
                    <button type="button" id="add-newspaper-button" class="btn btn-primary"><?= Yii::t('app', 'Add newspaper') ?></button>
                </div>
            </div>
            <div class="col-md-10">
                <div id="ad-form-newspapers-container">
                    <?php foreach ($model->adNewspapers as $newspaper) { ?>
                        <?= $this->render('__form_newspaper', ['form' => $form, 'model' => $newspaper]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    
    <?php ActiveForm::end(); ?>

</div>
