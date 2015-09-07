<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AdJobLocation;
use common\models\AdNewspaper;

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
                <?= $form->field($model, 'job_name')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Select job'),
                    ])
                    ->label(false)
                ?>
            </div>
        </div>
            

        <div id="ad-form-job-locations-container">
            <?php if ($model->isNewRecord) { ?>
                <?= $this->render('__form_job_location', ['form' => $form, 'model' => new AdJobLocation()]) ?>
            <?php } ?>
            
            <?php foreach ($model->adJobLocations as $jobLocation) { ?>
                <?= $this->render('__form_job_location', ['form' => $form, 'model' => $jobLocation]) ?>
            <?php } ?>
        </div>
        
        <div class="space"></div>
        <div class="space"></div>
        
        
        <div id="ad-form-newspapers-container">
            <?php if ($model->isNewRecord) { ?>
                <?= $this->render('__form_newspaper', ['form' => $form, 'model' => new AdNewspaper()]) ?>
            <?php } ?>
            
            <?php foreach ($model->adNewspapers as $newspaper) { ?>
                <?= $this->render('__form_newspaper', ['form' => $form, 'model' => $newspaper]) ?>
            <?php } ?>
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
