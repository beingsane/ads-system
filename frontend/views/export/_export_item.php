<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $itemModels common\models\ExportItem[] */

// we should group ads on the same job, paper and date
// and output all job locations in one export item
// $itemModels contains ExportItem model on the same job, paper and date
// so we can use one item to output ad info

if (!$itemModels) return;

$mainItem = $itemModels[0];
$model = $mainItem->adNewspaper->ad;
?>

<div class="export-item">

    <br>
    <div>
        <b><?= $model->job->job_name ?></b>
        <br>

        <?php
            $content = [];
            foreach ($itemModels as $itemModel) {
                foreach ($itemModel->adNewspaper->ad->adJobLocations as $adJobLocation) {
                    $itemText = [];
                    if ($adJobLocation->job_location) $itemText[] = $adJobLocation->job_location;
                    if ($adJobLocation->street_names) $itemText[] = $adJobLocation->street_names;
                    if ($adJobLocation->additional_info) $itemText[] = $adJobLocation->additional_info;

                    $content[] = implode('. ', $itemText) .'.';
                }
            }

            echo implode('<br>', $content);
        ?>
    </div>
    <br>

    <div>
        <?php foreach ($model->adNewspapers as $adNewspaper) { ?>
            <b><?= $adNewspaper->newspaper->newspaper_name ?>:</b>
            &nbsp;&nbsp;
            <?= $mainItem ?><br>
        <?php } ?>
    </div>
    <br>

</div>
