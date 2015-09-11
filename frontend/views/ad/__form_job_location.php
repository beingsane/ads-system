<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdJobLocation */
/* @var $n integer */

if (!isset($showLabel)) $showLabel = true;
if (!isset($showRemoveButton)) $showRemoveButton = false;
if (!isset($n)) $n = 0;

?>

<div class="location-item">
    <div class="right-control">
        <button class="location-remove-item btn btn-default" type="button">×</button>
        <?php if ($model->id) echo Html::activeHiddenInput($model, '['.$n.']id'); ?>
    </div>
    
    <div class="has-right-control">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, '['.$n.']job_location')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('job_location'),
                        'title' => $model->getAttributeLabel('job_location'),
                    ])
                    ->label(false)
                ?>
            </div>
            
            <div class="col-md-6">
                <?= $form->field($model, '['.$n.']additional_info')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('additional_info'),
                        'title' => $model->getAttributeLabel('additional_info'),
                    ])
                    ->label(false)
                ?>
            </div>
        </div>
    </div>
</div>
