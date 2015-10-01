<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Render;
use backend\models\JobSearch;

/* @var $this yii\web\View */
/* @var $model common\models\AdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php $render = new Render($form, $model); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...'), 'title' => Yii::t('app', 'Job')]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id')->textInput(['title' => 'Ad ID']) ?>
        </div>
    </div>

    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
