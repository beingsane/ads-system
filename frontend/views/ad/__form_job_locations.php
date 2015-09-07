<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdJobLocation */

?>

<div class="ad-form-job-location">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'job_location')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        
        <div class="col-md-6">
            <?= $form->field($model, 'additional_info')->textInput(['maxlength' => true])->label(false) ?>
        </div>
    </div>
</div>
