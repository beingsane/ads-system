<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExportItemSearch */
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

            'id',
            'ad_newspaper_id',
            'placement_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
