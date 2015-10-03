<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = Yii::t('app', 'View').': '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => \common\helpers\UrlHelper::previous()];
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
            <div class="col-sm-12 m-b-md">
                <b class="text-uppercase">[<?= Yii::t('app', 'Deleted') ?>]</b>
                <div class="space"></div>
                <div class="space"></div>
            </div>
        <?php } ?>

        <div class="col-sm-12">
            <b><?= $model->job->job_name ?></b>
            <br>

            <?php
                $content = [];
                foreach ($model->adJobLocations as $adJobLocation) {
                    $itemText = [];
                    if ($adJobLocation->job_location) $itemText[] = $adJobLocation->job_location;
                    if ($adJobLocation->street_names) $itemText[] = $adJobLocation->street_names;
                    if ($adJobLocation->additional_info) $itemText[] = $adJobLocation->additional_info;

                    $content[] = implode('. ', $itemText);
                }

                echo implode('<br>', $content);
            ?>
        </div>

        <div class="col-sm-12 m-t-md">
            <?php foreach ($model->adNewspapers as $adNewspaper) { ?>
                <b><?= $adNewspaper->newspaper->newspaper_name ?>:</b>
                &nbsp;&nbsp;
                <?= implode(';&nbsp;&nbsp;', $adNewspaper->adNewspaperPlacementDates) ?><br>
            <?php } ?>
        </div>
    </div>
</div>
