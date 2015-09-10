<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AdJobLocation;
use common\models\AdNewspaper;
use common\widgets\dynamicform\DynamicFormWidget;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <div class="col-md-12">
                <label class="control-label"><?= Yii::t('app', 'Job') ?></label>
                
                <?= $form->field($model, 'job_id')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Select job'),
                        'title' => Yii::t('app', 'Select job'),
                    ])
                    ->label(false)
                ?>
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
            <div class="col-md-12">
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
            
            $dateControlOptions = [
                'id' => 'tmp-'.$n.'-new_ad_date',
                'name' => '['.$n.']new_ad_date',
                'type' => 'date',
                'displayFormat' => 'dd-MM-yyyy',
                'saveFormat' => 'yyyy-MM-dd',
                'options' => [
                    'pluginOptions' => ['autoclose' => true],
                    'removeButton' => false,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Placement date'),
                        'title' => Yii::t('app', 'Placement date'),
                    ],
                ],
            ];
            
            // get DateControl object to access settings
            ob_start();
            $dateControl = DateControl::begin($dateControlOptions);
            DateControl::end();
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
            <div class="col-md-12">
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
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php
    $script = "
        $(document).ready(function() {
            function init(mainContainer)
            {
                var datecontrol_opt = ".json_encode($dateControl->pluginOptions).";
                datecontrol_opt['idSave'] = jQuery('[id$=\"new_ad_date\"]', mainContainer).attr('id');
                var kvDatepicker_opt = ".json_encode(['format' => 'dd-mm-yyyy', 'autoclose' => true]).";
                jQuery('[id$=\"new_ad_date-disp\"]', mainContainer).datecontrol(datecontrol_opt);
                var kvDatePicker = jQuery('[id$=\"new_ad_date-disp-kvdate\"]', mainContainer).kvDatepicker(kvDatepicker_opt);
                
                
                var container = $('.placement_date-container', mainContainer);
                
                function updateDateContaiter(dispVal, val)
                {
                    var valueExists = false;
                    container.find('input').each(function(i, e) {
                        if ($(this).val() == val) {
                            valueExists = true;
                            return false;
                        }
                        
                        return true;
                    });
                    if (valueExists) return;
                    
                    $('.dates-add-item', mainContainer).trigger('click');
                    var item = $('.tag-choice', container).last();
                    item.find('input').val(val);
                    item.find('.date-text').text(dispVal);
                    
                    // add 'has-success' class after adding date
                    kvDatePicker.closest('.form-group')
                        .removeClass('has-error')
                        .addClass('has-success')
                        .find('.help-block')
                        .html('');
                }
                
                $('[id$=\"new_ad_date\"]', mainContainer).off('change');
                $('[id$=\"new_ad_date\"]', mainContainer).on('change', function() {
                    var datepicker = $(this).parent().find('#' + $(this).attr('id') + '-disp-kvdate');
                    var dispVal = datepicker.find('input').val(), val = $(this).val();
                    if (val) {
                        updateDateContaiter(dispVal, val);
                        datepicker.kvDatepicker('clearDates');
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
        
    ";
    $this->registerJs($script, $this::POS_END);
?>
