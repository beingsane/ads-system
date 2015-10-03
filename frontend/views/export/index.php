<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExportItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Export');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="export-item-index">


    <div class="space"></div>
    <div class="space"></div>


    <span class="pull-left">
        <h1 class="no-margin"><?= Html::encode($this->title) ?></h1>
    </span>

    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app', 'Export'), ['class' => 'btn btn-success btn-export pull-right']) ?>
    </div>
    <div class="clearfix"></div>


    <div class="space"></div>
    <div class="space"></div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#filter-export">
                <?= Yii::t('app', 'Filter') ?>
            </a>
            <?= Html::a('<span class="text-muted">Reset filter</span>', ['index'], ['class' => 'pull-right']) ?>
        </div>
        <div id="filter-export" class="panel-collapse collapse save-filter-state <?= isset($_COOKIE['filter-export-state']) && $_COOKIE['filter-export-state'] ? 'in' : 'out' ?>">
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
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'adNewspaper.ad.id',
                'label' => Yii::t('app', 'Ad ID'),
            ],

            [
                'attribute' => 'adNewspaper.ad.job.job_name',
                'label' => Yii::t('app', 'Job'),
            ],

            [
                'attribute' => 'job_locations',
                'label' => Yii::t('app', 'Job locations'),
                'content' => function ($model, $key, $index, $column) {
                    $ad = $model->adNewspaper->ad;
                    $html = '';

                    $content = [];
                    foreach ($ad->adJobLocations as $adJobLocation) {
                        $itemText = [];
                        if ($adJobLocation->job_location) $itemText[] = $adJobLocation->job_location;
                        if ($adJobLocation->street_names) $itemText[] = $adJobLocation->street_names;
                        if ($adJobLocation->additional_info) $itemText[] = $adJobLocation->additional_info;

                        $content[] = implode('. ', $itemText);
                    }
                    $html .= implode('<br>', $content);
                    $html .= '<br>';

                    return $html;
                }
            ],

            [
                'attribute' => 'adNewspaper.newspaper.newspaper_name',
                'label' => Yii::t('app', 'Newspaper edition'),
            ],

            'placement_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{info}',
                'buttons' => [
                    'info' => function ($url, $model, $key) {
                        $html = '';
                        $html .= '<div class="text-center">';

                        $html .= Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                            ['/ad/view', 'id' => $model->adNewspaper->ad->id],
                            ['title' => Yii::t('app', 'View ad')]
                        );

                        $html .= '<br/>';
                        $html .= Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                            ['/ad/update', 'id' => $model->adNewspaper->ad->id],
                            ['title' => Yii::t('app', 'Edit ad')]
                        );

                        $html .= '<br/>';
                        $html .= Html::a('<i class="glyphicon glyphicon-trash"></i>',
                            ['/export/delete-date-item', 'id' => $model->id],
                            ['data-method' => 'post', 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item from export'), 'title' => Yii::t('app', 'Delete this item from export')]
                        );

                        $html .= '</div>';
                        return $html;
                    },
                ]
            ],
        ],
    ]); ?>

</div>

<?php
    $script = "
        $('.btn-export').click(function() {
            var form = $('#export-filter-form');
            var attr = form.attr('action');
            form.attr('action', '".Url::toRoute(['/export/export'])."').submit();
        });
    ";
    $this->registerJs($script);
?>

