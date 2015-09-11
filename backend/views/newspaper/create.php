<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Newspaper */

$this->title = Yii::t('app', 'Create Newspaper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newspapers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newspaper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
