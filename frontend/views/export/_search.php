<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\Render;
use backend\models\JobSearch;
use backend\models\NewspaperSearch;

/* @var $this yii\web\View */
/* @var $model frontend\models\ExportItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="export-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'enableClientValidation' => false,
    ]); ?>
    <?php $render = new Render($form, $model); ?>


    <div class="row">
        <div class="col-sm-6">
            <?= $render->dateField('date_from') ?>
        </div>

        <div class="col-sm-6">
            <?= $render->dateField('date_to') ?>
        </div>

        <div class="col-sm-6">
            <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...'), 'title' => Yii::t('app', 'Job')]) ?>
        </div>

        <div class="col-sm-6">
            <?= $render->selectField('newspaper_id', NewspaperSearch::newspaperList(), ['placeholder' => Yii::t('app', 'Select newspaper...'), 'title' => Yii::t('app', 'Newspaper edition')]) ?>
        </div>

        <div class="col-sm-6">
            <?= $render->textField('text') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'id')->textInput(['title' => 'Ad ID']) ?>
        </div>
    </div>

    <div class="form-group no-margin">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $script = "
        $('.btn-export').click(function() {
            alert('todo');

            var form = $(this).closest('form');
            var attr = form.attr('action');
            form.attr('action', '".Url::toRoute(['/export/export'])."').submit();

            setTimeout(function() {
                form.attr('action', attr);
            }, 1000);
        });
    ";
    $this->registerJs($script);
?>
