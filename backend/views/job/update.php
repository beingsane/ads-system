<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Job */

$this->title = Yii::t('app', 'Update job') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
