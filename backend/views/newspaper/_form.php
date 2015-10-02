<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Newspaper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="newspaper-form m-t-lg">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'newspaper_name')->textInput(['maxlength' => true]) ?>


    <label class="control-label m-t-md m-b-md">
        <?= $model->getAttributelabel('publishDays') ?>
    </label>

    <div class="m-b-lg">
        <?php
            $publishDays = $model->publishDays;
            foreach ($model::publishDaysList() as $day => $dayName) {
                echo $form->field($model, 'publishDays['.$day.']')->checkbox(['label' => $dayName])->label(false);
            }
        ?>
    </div>

    <div class="form-group m-t-lg">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
