<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ad */

$this->title = Yii::t('app', 'View').': '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-view">

    <div>
        <div class="pull-left h3 m-t-xs"><b><?= Html::encode(Yii::t('app', 'ID').': '.$model->id) ?></b></div>

        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            
            <?php if ($model->getStatus() != $model::STATUS_DELETED) { ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>
        </div>
    </div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    <div class="space"></div>
    
    <div class="row">
        <?php if ($model->getStatus() == $model::STATUS_DELETED) { ?>
            <div class="col-md-12">
                <b class="text-uppercase">[<?= Yii::t('app', 'Deleted') ?>]</b>
                <div class="space"></div>
                <div class="space"></div>
            </div>
        <?php } ?>
        
        <div class="col-md-12 m-t-md">
            <b><?= $model->job->job_name ?></b>
            <br>
            
            <?php foreach ($model->adJobLocations as $adJobLocation) { ?>
                <?= $adJobLocation->job_location ?><?= $adJobLocation->additional_info ? '. '.$adJobLocation->additional_info : '' ?><br>
            <?php } ?>
        </div>
        
        <div class="col-md-12 m-t-md">
            <?php foreach ($model->adNewspapers as $adNewspaper) { ?>
                <b><?= $adNewspaper->newspaper->newspaper_name ?>:</b>
                &nbsp;&nbsp;
                <?= implode(';&nbsp;&nbsp;', $adNewspaper->adNewspaperPlacementDates) ?><br>
            <?php } ?>
        </div>
    </div>

</div>
