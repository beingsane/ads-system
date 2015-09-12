<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Render;
use backend\models\JobSearch;

/* @var $this yii\web\View */
/* @var $model frontend\models\AdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php $render = new Render($form, $model); ?>

    <?= $form->field($model, 'id') ?>

    <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...')]) ?>
    
    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
