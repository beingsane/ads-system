<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExportItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Export'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="export-item-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['tag' => false],
        'itemView' => function($item) use($searchModel) {
            return $this->render('_export_item', ['item' => $item, 'searchModel' => $searchModel]);
        },
        'layout' => '{items}',
    ]) ?>

</div>
