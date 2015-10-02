<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Newspaper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Newspaper',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newspapers'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="newspaper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
