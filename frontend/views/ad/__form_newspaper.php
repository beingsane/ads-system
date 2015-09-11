<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datecontrol\DateControl;
use common\widgets\dynamicform\DynamicFormWidget;
use common\models\AdNewspaperPlacementDate;
use backend\models\NewspaperSearch;
use common\helpers\Render;

/* @var $this yii\web\View */
/* @var $render common\helpers\Render */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdNewspaper */
/* @var $n integer */

if (!isset($n)) $n = 0;

$render = new Render($form, $model);
?>

<div class="newspaper-item">
    <div class="right-control">
        <button class="newspaper-remove-item btn btn-default" type="button">×</button>
    </div>
    
    <div class="has-right-control">
        <div class="row">
            <div class="col-md-12">
                <?= $render->selectField('['.$n.']newspaper_id', NewspaperSearch::jobList(), ['placeholder' => Yii::t('app', 'Select newspaper...')])->label(false) ?>
            </div>
            
            
            
            <?php
                $models = $model->adNewspaperPlacementDates;
            ?>
            <?php $dateModel = new AdNewspaperPlacementDate(); ?>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_newspaper_dates', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.placement_date-container', // required: css class selector
                'widgetItem' => '.tag-choice', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.dates-add-item', // css class
                'deleteButton' => '.tag-choice-remove', // css class
                'model' => $dateModel,
                'template' => $this->render('__form_newspaper_date', ['form' => $form, 'model' => $dateModel, 'n' => $n, 'i' => 0]),
                'formId' => $form->id,
                'formFields' => [
                    'placement_date',
                ],
            ]); ?>
            
            <div class="col-md-3">
                <?php $errors = $model->getErrors('adNewspaperPlacementDates'); ?>
                
                <div class="form-group required <?= (empty($errors) ? '' : 'has-error') ?>">
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
                        
                        
                        if (!empty($errors)) {
                            echo Html::tag('div', Html::encode(implode('<br>', $errors)), ['class' => 'help-block']);
                        }
                    ?>
                    <button type="button" class="btn btn-primary btn-xs dates-add-item hidden"></button>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="placement_date-container tag-choice-container">
                    <?php foreach ($models as $i => $dateModel) { ?>
                        <?= $this->render('__form_newspaper_date', ['form' => $form, 'model' => $dateModel, 'n' => $n, 'i' => $i]) ?>
                    <?php } ?>
                </div>
            </div>
            
            <?php DynamicFormWidget::end(); ?>

        </div>
    </div>
    
    <div class="space"></div>
    <div class="space"></div>
</div>
