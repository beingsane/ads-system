<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datecontrol\DateControl;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdNewspaper */
/* @var $n integer */

if (!isset($n)) $n = 0;

?>

<div class="newspaper-item">
    <div class="right-control">
        <button class="newspaper-remove-item btn btn-default" type="button">×</button>
    </div>
    
    <div class="has-right-control">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, '['.$n.']newspaper_id')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Select newspaper'),
                        'title' => Yii::t('app', 'Select newspaper'),
                    ])
                    ->label(false) ?>
            </div>
            
            
            
            
            
            
            <?php
                $models = $model->adNewspaperPlacementDates;
                if (empty($models)) $models = [new \common\models\AdNewspaperPlacementDate()];
            ?>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_newspaper_dates', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.placement_date-container', // required: css class selector
                'widgetItem' => '.tag-choice', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.dates-add-item', // css class
                'deleteButton' => '.tag-choice-remove', // css class
                'model' => $models[0],
                'formId' => $form->id,
                'formFields' => [
                    'placement_date',
                ],
            ]); ?>
            
            <div class="col-md-3">
                <div class="form-group">
                    <?php
                        $dateControl = DateControl::begin([
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
                        ]);
                        DateControl::end();
                    ?>
                    <button type="button" class="btn btn-primary btn-xs dates-add-item hidden"></button>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="placement_date-container tag-choice-container">
                    <?php foreach ($models as $i => $dateModel) { ?>
                        <div class="tag-choice" title="<?= $dateModel->placement_date ?>">
                            <span class="tag-choice-remove">×</span>
                            
                            <span class="date-text"><?= $dateModel->placement_date ?></span>
                            
                            <?= $form->field($dateModel, '['.$n.']['.$i.']placement_date', ['options' => ['class' => 'hidden']])
                                ->hiddenInput(['maxlength' => true])
                                ->label(false)
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
    
    <div class="space"></div>
    <div class="space"></div>
</div>

<?php
    $script = "
        $(document).ready(function() {
            function init()
            {
                var mainContainer = $('.newspaper-item').last();
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
                }
                
                $('body').off('click', '.tag-choice-remove');
                $('body').on('click', '.tag-choice-remove', function() {
                    $(this).closest('.tag-choice').remove();
                });
                
                $('[id$=\"new_ad_date\"]', mainContainer).off('change');
                $('[id$=\"new_ad_date\"]', mainContainer).on('change', function() {
                    var datepicker = $(this).parent().find('#' + $(this).attr('id') + '-disp-kvdate');
                    var dispVal = datepicker.find('input').val(), val = $(this).val();
                    if (val) {
                        updateDateContaiter(dispVal, val);
                        datepicker.kvDatepicker('clearDates');
                    }
                });
            }
            
            $('.dynamicform_wrapper_newspapers').on('afterInsert', function(e, item) {
                var datecontrol_opt = ".json_encode($dateControl->pluginOptions).";
                datecontrol_opt['idSave'] = jQuery('[id$=\"new_ad_date\"]', item).attr('id');
                var kvDatepicker_opt = ".json_encode(['format' => 'dd-mm-yyyy', 'autoclose' => true]).";
                jQuery('[id$=\"new_ad_date-disp\"]', item).datecontrol(datecontrol_opt);
                jQuery('[id$=\"new_ad_date-disp-kvdate\"]', item).kvDatepicker(kvDatepicker_opt);
                
                init();
            });
            
            init();
        });
        
    ";
    $this->registerJs($script, $this::POS_END);
?>
