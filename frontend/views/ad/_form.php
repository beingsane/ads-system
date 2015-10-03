<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AdJobLocation;
use common\models\AdNewspaper;
use common\widgets\dynamicform\DynamicFormWidget;
use common\helpers\Render;
use backend\models\JobSearch;
use common\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $render = new Render($form, $model); ?>

        <div class="row">
            <div class="col-sm-12">
                <?php if ($model->id) echo Html::activeHiddenInput($model, 'id'); ?>

                <label class="control-label"><?= Yii::t('app', 'Job') ?></label>

                <?= $render->selectField('job_id', JobSearch::jobList(), ['placeholder' => Yii::t('app', 'Select job...')])->label(false) ?>
            </div>
        </div>




        <?php
            $models = $model->adJobLocations;
            if (empty($models)) $models = [new AdJobLocation()];
        ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_locations', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.location-container-items', // required: css class selector
            'widgetItem' => '.location-item', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.location-add-item', // css class
            'deleteButton' => '.location-remove-item', // css class
            'model' => $models[0],
            'formId' => $form->id,
            'formFields' => [
                'job_location',
                'additional_info',
            ],
        ]); ?>

        <div class="row m-t-lg m-b-md">
            <div class="col-sm-12">
                <label class="control-label"><?= Yii::t('app', 'Job Location') ?></label>

                <div class="pull-right">
                    <button type="button"
                        class="btn btn-primary btn-xs location-add-item"
                    >
                        + <?= Yii::t('app', 'Add location') ?>
                    </button>
                </div>
            </div>
        </div>

        <div class="location-container-items">
            <?php foreach ($models as $n => $jobLocation) { ?>
                <?= $this->render('__form_job_location', ['form' => $form, 'model' => $jobLocation, 'n' => $n]) ?>
            <?php } ?>
        </div>

        <?php DynamicFormWidget::end(); ?>







        <?php
            $models = $model->adNewspapers;
            if (empty($models)) $models = [new AdNewspaper()];

            ob_start();
            $datePicker = DatePicker::begin([
                'id' => 'tmp-'.$n.'-new_ad_date',
                'name' => '['.$n.']new_ad_date',
                'language' => Yii::$app->language,
                'saveDateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'placeholder' => Yii::t('app', 'Placement date'),
                    'title' => Yii::t('app', 'Placement date'),
                    'class' => 'form-control',
                ],
            ]);
            DatePicker::end();
            ob_get_clean();
        ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_newspapers', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.newspaper-container-items', // required: css class selector
            'widgetItem' => '.newspaper-item', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.newspaper-add-item', // css class
            'deleteButton' => '.newspaper-remove-item', // css class
            'model' => new AdNewspaper(),
            'template' => $this->render('__form_newspaper', ['form' => $form, 'model' => new AdNewspaper(), 'n' => 0]),
            'formId' => $form->id,
            'formFields' => [
                'job_location',
                'additional_info',
            ],
        ]); ?>

        <div class="row m-t-lg m-b-md">
            <div class="col-sm-12">
                <label class="control-label"><?= Yii::t('app', 'Newspaper edition') ?></label>

                <div class="pull-right">
                    <button type="button"
                        class="btn btn-primary btn-xs newspaper-add-item"
                    >
                        + <?= Yii::t('app', 'Add newspaper') ?>
                    </button>
                </div>
            </div>
        </div>

        <div class="newspaper-container-items">
            <?php foreach ($models as $n => $newspaper) { ?>
                <?= $this->render('__form_newspaper', ['form' => $form, 'model' => $newspaper, 'n' => $n]) ?>
            <?php } ?>
        </div>

        <?php DynamicFormWidget::end(); ?>





        <div class="space"></div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
<?php ob_start(); ?>
    $(document).ready(function() {
        function init(mainContainer)
        {
            var datepicker_id = $('[id$="new_ad_date"]', mainContainer).attr('id');
            var datepicker = $('#' + datepicker_id, mainContainer)
            var dateContainer = $('.placement_date-container', mainContainer);

            function initDatePicker(clearDates)
            {
                datepicker = $('#' + datepicker_id).datepicker($.extend({},
                    $.datepicker.regional['<?= $datePicker->language ?>'],
                    <?= json_encode($datePicker->clientOptions) ?>,
                    {
                        beforeShowDay: function(date) {
                            var newspaperSelect = $('[id$=newspaper_id]', mainContainer);
                            var params = newspaperSelect.find('option:selected').data('params');
                            if (!params) return [false];

                            var publishDays = params.publishDays;

                            var dayOfWeek = date.getDay();
                            if (dayOfWeek == 0) dayOfWeek = 7;
                            return [publishDays[dayOfWeek] == 1];
                        }
                    }
                ));

                if (clearDates) {
                    datepicker.closest('.form-group').removeClass('has-success');
                    $('.tag-choice', dateContainer).remove();
                }

                datepicker.change(function() {
                    var savedValue = $.datepicker.formatDate('<?= $datePicker->saveDateFormatJs ?>', $(this).datepicker('getDate'));
                    $('#' + $(this).attr('id') + '-saved-value').val(savedValue).trigger('change');
                });
            }
            initDatePicker(false);

            $('[id$=newspaper_id]', mainContainer).change(function() {
                initDatePicker(true);
            });


            function updateDateContaiter(dispVal, val)
            {
                var valueExists = false;
                dateContainer.find('input').each(function(i, e) {
                    if ($(this).val() == val) {
                        valueExists = true;
                        return false;
                    }

                    return true;
                });
                if (valueExists) return;

                $('.dates-add-item', mainContainer).trigger('click');
                var item = $('.tag-choice', dateContainer).last();
                item.find('input').val(val);
                item.find('.date-text').text(dispVal);

                // add 'has-success' class after adding date
                datepicker.closest('.form-group')
                    .removeClass('has-error')
                    .addClass('has-success')
                    .find('.help-block')
                    .html('');
            }

            $('[id$="new_ad_date-saved-value"]', mainContainer).off('change');
            $('[id$="new_ad_date-saved-value"]', mainContainer).on('change', function() {
                var dispVal = $(this).prev('.hasDatepicker').val(), val = $(this).val();
                if (val) {
                    updateDateContaiter(dispVal, val);
                    $(this).prev('.hasDatepicker').val('');
                    $(this).val('');
                }
            });
        }

        $('.dynamicform_wrapper_newspapers').on('afterInsert', function(e, item) {
            var mainContainer = $('.newspaper-item').last();
            init(mainContainer);
        });

        $('.newspaper-item').each(function() {
            var mainContainer = $(this);
            init(mainContainer);
        });
    });
<?php $script = ob_get_clean(); ?>
</script>

<?php $this->registerJs($script, $this::POS_END); ?>
