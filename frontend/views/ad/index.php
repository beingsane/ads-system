<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Ad;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');
?>
<div class="ad-index">

    <div class="space"></div>
    <div class="space"></div>


    <span class="pull-left">
        <h1 class="no-margin"><?= Html::encode($this->title) ?></h1>
    </span>
    <span class="pull-right">
        <?= Html::a(Yii::t('app', 'Create Ad'), ['create'], ['class' => 'btn btn-success']) ?>
    </span>
    <div class="clearfix"></div>


    <div class="space"></div>
    <div class="space"></div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#filter">
                <?= Yii::t('app', 'Filter') ?>
            </a>
            <?= Html::a('<span class="text-muted">Reset filter</span>', ['index'], ['class' => 'pull-right']) ?>
        </div>
        <div id="filter" class="panel-collapse collapse save-filter-state <?= isset($_COOKIE['filter-state']) && $_COOKIE['filter-state'] ? 'in' : 'out' ?>">
            <div class="panel-body">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>


    <div class="space"></div>
    <div class="space"></div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'job',
                'content' => function ($model, $key, $index, $column) {
                    return $model->job->job_name;
                },
            ],

            [
                'attribute' => 'adJobLocations',
                'content' => function ($model, $key, $index, $column) {
                    $content = [];
                    foreach ($model->adJobLocations as $adJobLocation) {
                        $itemText = [];
                        if ($adJobLocation->job_location) $itemText[] = $adJobLocation->job_location;
                        if ($adJobLocation->street_names) $itemText[] = $adJobLocation->street_names;
                        if ($adJobLocation->additional_info) $itemText[] = $adJobLocation->additional_info;

                        $content[] = implode('. ', $itemText);
                    }

                    return implode('<br>', $content);
                },
            ],

            [
                'attribute' => 'adNewspapers',
                'content' => function ($model, $key, $index, $column) {
                    $content = [];
                    foreach ($model->adNewspapers as $adNewspaper) {
                        $itemText = [];
                        $itemText[] = $adNewspaper->newspaper->newspaper_name.':';
                        $itemText[] = implode(';&nbsp;&nbsp;', $adNewspaper->adNewspaperPlacementDates);

                        $content[] = implode('&nbsp;&nbsp;', $itemText);
                    }

                    return implode('<br>', $content);
                },
            ],

            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}<br>{update}<br>{delete}'],
        ],
    ]); ?>

</div>
