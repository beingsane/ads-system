<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\Render;
use backend\models\JobSearch;
use backend\models\NewspaperSearch;

/* @var $this yii\web\View */
/* @var $model frontend\models\AdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'enableClientValidation' => false,
    ]); ?>
    <?php $render = new Render($form, $model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $render->dateField('date_from') ?>
        </div>

        <div class="col-sm-6">
            <?= $render->dateField('date_to') ?>
        </div>

        <div class="col-sm-6">
            <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...'), 'title' => Yii::t('app', 'Job')]) ?>
        </div>

        <div class="col-sm-6">
            <?= $render->selectField('newspaper_id', NewspaperSearch::newspaperList(), ['placeholder' => Yii::t('app', 'Select newspaper...'), 'title' => Yii::t('app', 'Newspaper edition')]) ?>
        </div>

        <div class="col-sm-6">
            <?= $render->textField('text') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'id')->textInput(['title' => 'Ad ID']) ?>
        </div>
    </div>

    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Delete all'), ['delete-all'], [
                'class' => 'btn btn-danger btn-delete-all',
                'title' => Yii::t('app', 'Find ads that match this filter and delete all found'),
                'data-method' => 'post',
                'data-confirm' => Yii::t('app', 'Are you sure you want to delete all ads that match this filter?'),
                'data-params' => ['_csrf' => Yii::$app->request->getCsrfToken()],
            ]) ?>
        </span>
    </div>

    <?php ActiveForm::end(); ?>

</div>
