<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExportItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Export');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Export'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = $this->title;


$items = [];
foreach ($dataProvider->models as $model) {
    $key = $model->adNewspaper->ad->job_id .'_' .$model->adNewspaper->newspaper_id .'_' .$model->placement_date;
    $items[$key][] = $model;
}

?>

<div class="export-item-index">
    <?php
        foreach ($items as $key => $itemModels) {
            echo $this->render('_export_item', ['itemModels' => $itemModels]);
        }
    ?>
</div>
