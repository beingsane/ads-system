<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdJobLocation */

if (!isset($showLabel)) $showLabel = true;
if (!isset($showRemoveButton)) $showRemoveButton = false;

?>

<div class="ad-form-job-location">
    <div class="row">
        <div class="col-md-2">
            <?php if ($showLabel) { ?>
                <label class="control-label"><?= Yii::t('app', 'Job Location') ?></label>
                    
                <div class="text-right m-t-xs m-b-lg">
                    <button type="button"
                        id="add-location-button"
                        class="btn btn-primary btn-xs add-ajax"
                        data-url="<?= Url::to(['ad/get-job-location-form']) ?>"
                        data-container="#ad-form-job-locations-container"
                    >
                        + <?= Yii::t('app', 'Add location') ?>
                    </button>
                </div>
            <?php } ?>
            
            <?php if ($showRemoveButton) { ?>
                <button class="close remove-item" aria-hidden="true" data-dismiss=".ajax-item" type="button">×</button>
            <?php } ?>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, '[]job_location[]')
                        ->textInput([
                            'maxlength' => true,
                            'placeholder' => $model->getAttributeLabel('job_location'),
                        ])
                        ->label(false)
                    ?>
                </div>
                
                <div class="col-md-6">
                    <?= $form->field($model, '[]additional_info[]')
                        ->textInput([
                            'maxlength' => true,
                            'placeholder' => $model->getAttributeLabel('additional_info'),
                        ])
                        ->label(false)
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
