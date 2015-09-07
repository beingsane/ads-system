<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datecontrol\DateControl;

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
                <?= $form->field($model, '['.$n.']newspaper_name')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('newspaper_name'),
                        'title' => $model->getAttributeLabel('newspaper_name'),
                    ])
                    ->label(false) ?>
            </div>
            
            
            <div class="col-md-3">
                <div class="form-group">
                    <?php
                        $dateControl = DateControl::begin([
                            'id' => 'test-'.$n.'-new_ad_date',
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
                </div>
            </div>
            
            
            <div class="col-md-9">
                <div class="form-group">
                    <div>
                        <div class="placement_date_ui_container tag-choice-container">
                            <?php foreach ($model->adNewspaperPlacementDates as $dateModel) { ?>
                                <div class="tag-choice" title="<?= $dateModel->placement_date ?>">
                                    <span class="tag-choice-remove">×</span>
                                    
                                    <?= $dateModel->placement_date ?>
                                    
                                    <?= $form->field($dateModel, '['.$n.']placement_date[]', ['options' => ['class' => 'hidden']])
                                        ->hiddenInput(['maxlength' => true])
                                        ->label(false)
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="placement_date_ui_container_item_template hidden">
                        <div class="tag-choice" title="{text}">
                            <span class="tag-choice-remove">×</span>
                            {text}
                            <?= $form->field(new \common\models\AdNewspaperPlacementDate(), '['.$n.']placement_date[]', ['options' => ['class' => 'hidden']])
                                ->hiddenInput(['maxlength' => true])
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
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
                var container = $('.placement_date_ui_container', mainContainer);
                
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
                    
                    
                    var template = $('.placement_date_ui_container_item_template', mainContainer).html();
                    
                    var html = template;
                    var text = dispVal;
                    html = html.split('{text}').join(text);
                    
                    container.append(html);
                    container.find('input').last().val(val);
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
