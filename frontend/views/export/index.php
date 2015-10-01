<?php

use yii\helpers\Html;
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
    <div class="clearfix"></div>


    <div class="space"></div>
    <div class="space"></div>


    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


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
                'attribute' => 'text',
                'label' => Yii::t('app', 'Text'),
                'content' => function ($model, $key, $index, $column) {
                    $ad = $model->adNewspaper->ad;
                    $html = '';

                    $html .= $model->adNewspaper->newspaper->newspaper_name;
                    $html .= '<br>';

                    $html .= $ad->job->job_name;
                    $html .= '<br>';

                    foreach ($ad->adJobLocations as $adJobLocation) {
                        $html .= $adJobLocation->job_location .($adJobLocation->additional_info ? '. '.$adJobLocation->additional_info : '');
                        $html .= '<br>';
                    }

                    return $html;
                }
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
                            ['data-pjax' => '0', 'title' => Yii::t('app', 'View ad')]
                        );

                        $html .= '<br/>';
                        $html .= Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                            ['/ad/update', 'id' => $model->adNewspaper->ad->id],
                            ['data-pjax' => '0', 'title' => Yii::t('app', 'Edit ad')]
                        );

                        $html .= '<br/>';
                        $html .= Html::a('<i class="glyphicon glyphicon-trash"></i>',
                            ['/export/delete-date-item', 'id' => $model->id],
                            ['data-pjax' => '0', 'data-method' => 'post', 'title' => Yii::t('app', 'Delete this item from export')]
                        );

                        $html .= '</div>';
                        return $html;
                    },
                ]
            ],
        ],
    ]); ?>

</div>
