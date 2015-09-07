<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $parentModel common\models\Ad */
/* @var $models common\models\AdJobLocation[] */

if (!$models) {
    $models = [new \common\models\AdJobLocation()];
}
?>

<div class="ad-form-job-locations">
    <?php foreach ($models as $model) { ?>
    
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'job_location')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            
            <div class="col-md-6">
                <?= $form->field($model, 'additional_info')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
        
    <?php } ?>
</div>
