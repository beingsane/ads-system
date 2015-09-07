<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdNewspaper */

if (!isset($showLabel)) $showLabel = true;
if (!isset($showRemoveButton)) $showRemoveButton = false;
?>

<div class="ad-form-newspaper">
    <div class="row">
        <div class="col-md-2">
            <?php if ($showLabel) { ?>
                <label class="control-label"><?= Yii::t('app', 'Newspaper Edition') ?></label>
                
                <div class="text-right m-t-xs m-b-lg">
                    <button type="button"
                        id="add-newspaper-button"
                        class="btn btn-primary btn-xs add-ajax"
                        data-url="<?= Url::to(['ad/get-newspaper-form']) ?>"
                        data-container="#ad-form-newspapers-container"
                    >
                        + <?= Yii::t('app', 'Add newspaper') ?>
                    </button>
                </div>
            <?php } ?>
            
            <?php if ($showRemoveButton) { ?>
                <button class="close remove-item" aria-hidden="true" data-dismiss=".ajax-item" type="button">×</button>
            <?php } ?>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'newspaper_name')
                        ->textInput([
                            'maxlength' => true,
                            'placeholder' => $model->getAttributeLabel('newspaper_name'),
                        ])
                        ->label(false) ?>
                </div>
                
                
                <div class="col-md-3">
                    <div class="form-group">
                        <?php
                            echo DateControl::widget([
                                'id' => uniqid(),
                                'name' => 'new_ad_date',
                                'type' => 'date',
                                'displayFormat' => 'dd-MM-yyyy',
                                'saveFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'pluginOptions' => ['autoclose' => true],
                                    'removeButton' => false,
                                    'options' => [
                                        'placeholder' => Yii::t('app', 'Placement date'),
                                    ],
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div>
                            <div id="placement_date-ui-container" class="tag-choice-container">
                                <?php foreach ($model->adNewspaperPlacementDates as $dateModel) { ?>
                                    <div class="tag-choice" title="<?= $dateModel->placement_date ?>">
                                        <span class="tag-choice-remove">×</span>
                                        
                                        <?= $dateModel->placement_date ?>
                                        
                                        <?= $form->field($dateModel, 'placement_date[]', ['options' => ['class' => 'hidden']])
                                            ->hiddenInput(['maxlength' => true])
                                            ->label(false)
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div id="placement_date-ui-container-item-template" class="hidden">
                            <div class="tag-choice" title="{text}">
                                <span class="tag-choice-remove">×</span>
                                {text}
                                <?= $form->field(new \common\models\AdNewspaperPlacementDate(), 'placement_date[]', ['options' => ['class' => 'hidden']])
                                    ->hiddenInput(['maxlength' => true])
                                    ->label(false)
                                ?>
                            </div>
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
            var mainContainer = $('.ad-form-newspaper').last();
            var container = $('#placement_date-ui-container', mainContainer);
            
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
                
                
                var template = $('#placement_date-ui-container-item-template').html();
                
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
            
            $('[name=\"new_ad_date\"]', mainContainer).change(function() {
                var datepicker = $(this).parent().find('#' + $(this).attr('id') + '-disp-kvdate');
                var dispVal = datepicker.find('input').val(), val = $(this).val();
                if (val) {
                    updateDateContaiter(dispVal, val);
                    datepicker.kvDatepicker('clearDates');
                }
            });
        });
    ";
    $this->registerJs($script, $this::POS_END);
?>
