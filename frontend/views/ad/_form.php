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
            <div class="col-md-2"><label class="control-label"><?= Yii::t('app', 'Job') ?></label></div>
            <div class="col-md-10">
                <?= $form->field($model, 'job_name')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-2"><label class="control-label"><?= Yii::t('app', 'Job Location') ?></label></div>
            <div class="col-md-10">
                <?= $this->render('__form_job_locations', ['form' => $form, 'parentModel' => $model, 'models' => $model->adJobLocations]) ?>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-2"><label class="control-label"><?= Yii::t('app', 'Newspaper Edition') ?></label></div>
            <div class="col-md-10">
                <?= $this->render('__form_newspapers', ['form' => $form, 'parentModel' => $model, 'models' => $model->adNewspapers]) ?>
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
