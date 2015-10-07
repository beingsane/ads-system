<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $item array */
?>

<div class="export-item">

    <br>
        <b><?= $item['job']->job_name ?></b>
        <br>

        <?php
            echo implode('<br>', $item['locations']);
        ?>
        <br>
    <br>
        <?php foreach ($item['newspapers_dates'] as $newspaper_id => $newspapers_dates) { ?>
            <b><?= $newspapers_dates['newspaper']->newspaper_name ?>:</b>&nbsp;

            <?= implode(';&nbsp;&nbsp;', $newspapers_dates['dates']) ?>
            <br>
        <?php } ?>
    <br>

</div>
