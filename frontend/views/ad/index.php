<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Ad;

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
            <a data-toggle="collapse" href="#work-orders-filter">
                <?= Yii::t('app', 'Filter') ?>
            </a>
            <?= Html::a('<span class="text-muted">Reset filter</span>', ['ad/index'], ['class' => 'pull-right']) ?>
        </div>
        <div id="work-orders-filter" class="panel-collapse collapse out">
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
                    return '<b>'.$model->job->job_name.'</b>';
                },
            ],

            [
                'attribute' => 'adJobLocations',
                'content' => function ($model, $key, $index, $column) {
                    $content = [];
                    foreach ($model->adJobLocations as $adJobLocation) {
                        $content[] = $adJobLocation->job_location .'. ' .$adJobLocation->additional_info;
                    }

                    return implode('<br>', $content);
                },
            ],

            [
                'attribute' => 'adNewspapers',
                'content' => function ($model, $key, $index, $column) {
                    $content = [];
                    foreach ($model->adNewspapers as $adNewspaper) {
                        $info = [];
                        $info[] = '<b>'.$adNewspaper->newspaper->newspaper_name.':</b>';
                        $info[] = implode(';&nbsp;&nbsp;', $adNewspaper->adNewspaperPlacementDates);

                        $content[] = implode('&nbsp;&nbsp;', $info);
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
