<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\helpers\Render;
use dektrium\user\models\User;
use backend\models\JobSearch;

/* @var $this yii\web\View */
/* @var $model backend\models\AdSearch */
/* @var $form yii\widgets\ActiveForm */

$userList = User::find()
    ->where(['not', ['confirmed_at' => null]])
    ->andWhere(['blocked_at' => null])
    ->all();

?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php $render = new Render($form, $model); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $render->selectField('user_id', ArrayHelper::map($userList, 'id', 'username'), ['placeholder' => Yii::t('app', 'Select user...'), 'title' => Yii::t('app', 'User')]) ?>
        </div>
        <div class="col-md-4">
            <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...'), 'title' => Yii::t('app', 'Job')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id')->textInput(['title' => 'Ad ID']) ?>
        </div>
    </div>

        
    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
