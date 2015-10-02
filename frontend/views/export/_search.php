<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\Render;

/* @var $this yii\web\View */
/* @var $model frontend\models\ExportItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="export-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php $render = new Render($form, $model); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $render->dateField('date_from') ?>
        </div>

        <div class="col-md-3">
            <?= $render->dateField('date_to') ?>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <div>
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <?= Html::button(Yii::t('app', 'Export'), ['class' => 'btn btn-success btn-export']) ?>


                    <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Ads for export today'), ['/export/index'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<?php
    $script = "
        $('.btn-export').click(function() {
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