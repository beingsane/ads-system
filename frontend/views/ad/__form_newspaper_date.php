<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\AdNewspaperPlacementDate */
/* @var $n integer */
/* @var $i integer */

if (!isset($n)) $n = 0;
if (!isset($i)) $i = 0;

?>

<div class="tag-choice" title="<?= $model->__toString() ?>">
    <span class="tag-choice-remove">×</span>
    
    <span class="date-text"><?= $model->__toString() ?></span>
    
    <?php if ($model->id) echo Html::activeHiddenInput($model, '['.$n.']['.$i.']id'); ?>
    
    <?= $form->field($model, '['.$n.']['.$i.']placement_date', ['options' => ['class' => 'hidden']])
        ->hiddenInput(['maxlength' => true])
        ->label(false)
    ?>
</div>
