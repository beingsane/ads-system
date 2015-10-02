<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Job */

$this->title = Yii::t('app', 'Create Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
