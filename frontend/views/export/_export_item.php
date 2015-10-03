<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $item common\models\ExportItem */
/* @var $searchModel common\models\ExportItemSearch */

$model = $item->adNewspaper->ad;
?>

<div class="export-item">

    <br>
    <div>
        <b><?= $model->job->job_name ?></b>
        <br>

        <?php
            $content = [];
            foreach ($model->adJobLocations as $adJobLocation) {
                $itemText = [];
                if ($adJobLocation->job_location) $itemText[] = $adJobLocation->job_location;
                if ($adJobLocation->street_names) $itemText[] = $adJobLocation->street_names;
                if ($adJobLocation->additional_info) $itemText[] = $adJobLocation->additional_info;

                $content[] = implode('. ', $itemText);
            }

            echo implode('<br>', $content);
        ?>
    </div>
    <br>

    <div>
        <?php foreach ($model->adNewspapers as $adNewspaper) { ?>
            <b><?= $adNewspaper->newspaper->newspaper_name ?>:</b>
            &nbsp;&nbsp;
            <?= $item ?><br>
        <?php } ?>
    </div>
    <br>

</div>
