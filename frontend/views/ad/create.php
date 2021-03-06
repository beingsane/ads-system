<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = Yii::t('app', 'Create Ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ad-create">

    <div class="text-center m-b-lg">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="space"></div>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <div class="clearfix"></div>

</div>
