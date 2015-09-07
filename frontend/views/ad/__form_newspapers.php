<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdNewspaper */

?>

<div class="ad-form-newspaper">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'newspaper_name')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        
        <div class="col-md-12">
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
            
            
            
            <?= $form->field(new \common\models\AdNewspaperPlacementDate(), 'placement_date', ['template' => '{hint}{error}'])
                ->label(false)
            ?>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
            <?php
                echo DateControl::widget([
                    'id' => 'new_ad_date',
                    'name' => 'new_ad_date',
                    'type' => 'date',
                    'displayFormat' => 'dd-MM-yyyy',
                    'saveFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'pluginOptions' => ['autoclose' => true],
                        'removeButton' => false,
                    ],
                ]);
            ?>
            </div>
        </div>
    </div>
</div>

<?php
    $script = "
        $(document).ready(function() {
            var container = $('#placement_date-ui-container');
            
            function updateDateContaiter(dispVal, val)
            {
                var template = $('#placement_date-ui-container-item-template').html();
                
                var html = template;
                var text = dispVal;
                html = html.split('{text}').join(text);
                
                container.append(html);
                container.find('input').last().val(val);
            }
            
            $('body').on('click', '.tag-choice-remove', function() {
                $(this).closest('.tag-choice').remove();
            });
            
            $('#new_ad_date').change(function() {
                var datepicker = $(this).parent().find('#new_ad_date-disp-kvdate');
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
