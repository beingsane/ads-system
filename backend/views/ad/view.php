<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

echo $this->render('@frontend/views/ad/view', ['model' => $model]);

$this->title = Yii::t('app', 'View').': '.$model->id;
$this->params['breadcrumbs'] = [];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>
