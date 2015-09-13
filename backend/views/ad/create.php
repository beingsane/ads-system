<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = Yii::t('app', 'Create Ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@frontend/views/ad/_form', [
        'model' => $model,
    ]) ?>

</div>
