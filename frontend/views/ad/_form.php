<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AdJobLocation;
use common\models\AdNewspaper;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <div class="col-md-12">
                <label class="control-label"><?= Yii::t('app', 'Job') ?></label>
                
                <?= $form->field($model, 'job_name')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Select job'),
                        'title' => Yii::t('app', 'Select job'),
                    ])
                    ->label(false)
                ?>
            </div>
        </div>
        
        
        <?php
            $models = $model->adJobLocations;
            if (empty($models)) $models = [new AdJobLocation()];
        ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_locations', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.location-container-items', // required: css class selector
            'widgetItem' => '.location-item', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.location-add-item', // css class
            'deleteButton' => '.location-remove-item', // css class
            'model' => $models[0],
            'formId' => $form->id,
            'formFields' => [
                'job_location',
                'additional_info',
            ],
        ]); ?>
        
        <div class="row m-t-lg m-b-md">
            <div class="col-md-12">
                <label class="control-label"><?= Yii::t('app', 'Job Location') ?></label>
                
                <div class="pull-right">
                    <button type="button"
                        class="btn btn-primary btn-xs location-add-item"
                    >
                        + <?= Yii::t('app', 'Add location') ?>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="location-container-items">
            <?php foreach ($models as $n => $jobLocation) { ?>
                <?= $this->render('__form_job_location', ['form' => $form, 'model' => $jobLocation, 'n' => $n]) ?>
            <?php } ?>
        </div>
        
        <?php DynamicFormWidget::end(); ?>
        
        
        
        
        
        
        
        <?php
            $models = $model->adNewspapers;
            if (empty($models)) $models = [new AdNewspaper()];
        ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_newspapers', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.newspaper-container-items', // required: css class selector
            'widgetItem' => '.newspaper-item', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.newspaper-add-item', // css class
            'deleteButton' => '.newspaper-remove-item', // css class
            'model' => $models[0],
            'formId' => $form->id,
            'formFields' => [
                'job_location',
                'additional_info',
            ],
        ]); ?>
        
        <div class="row m-t-lg m-b-md">
            <div class="col-md-12">
                <label class="control-label"><?= Yii::t('app', 'Newspaper edition') ?></label>
                
                <div class="pull-right">
                    <button type="button"
                        class="btn btn-primary btn-xs newspaper-add-item"
                    >
                        + <?= Yii::t('app', 'Add newspaper') ?>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="newspaper-container-items">
            <?php foreach ($models as $n => $newspaper) { ?>
                <?= $this->render('__form_newspaper', ['form' => $form, 'model' => $newspaper, 'n' => $n]) ?>
            <?php } ?>
        </div>
        
        <?php DynamicFormWidget::end(); ?>
        
        
        
        
        
        <div class="space"></div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    
    <?php ActiveForm::end(); ?>

</div>
