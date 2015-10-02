<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewspaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newspapers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newspaper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Newspaper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'newspaper_name',

            [
                'attribute' => 'publishDays',
                'content' => function ($model, $key, $index, $column) {
                    return $model->getPublishDaysText();
                }
            ],

            'statusHtml:html',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}\n{update}\n{delete}\n{restore}",
                'buttons' => [
                    'restore' => function ($url, $model, $key) {
                        $html = '';

                        if ($model->getStatus() == $model::STATUS_DELETED) {
                            $html .= Html::a(
                                '<span class="glyphicon glyphicon-upload"></span>',
                                ['restore', 'id' => $model->id],
                                ['title' => Yii::t('app', 'Restore'), 'data-method' => 'post', 'data-confirm' => Yii::t('app', 'Are you sure you want to restore this item?')]
                            );
                        }

                        return $html;
                    },
                ]
            ],
        ],
    ]); ?>

</div>
