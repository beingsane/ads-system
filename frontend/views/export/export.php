<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExportItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Export');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Export'), 'url' => \common\helpers\UrlHelper::previous()];
$this->params['breadcrumbs'][] = $this->title;




/*

We need to group by job name and job locations combination at the same date and newspaper


Example:

----------------
----------------

Ads page:

--------

Zusteller
Wiefelstede. test street name 2. test additional info 2
Hunte Report:  So., 11.10.2015
NWZ Ammerländer Nachrichten:  Sa., 03.10.2015;  Sa., 10.10.2015;  Sa., 17.10.2015

--------

Zusteller
Rastede. test street name 1. test additional info 1
Hunte Report:  So., 11.10.2015;  So., 18.10.2015
Frieslander Bote:  Di., 06.10.2015;  Di., 13.10.2015;  Di., 20.10.2015;  Di., 27.10.2015

----------------
----------------

Export page:

--------

Zusteller
Rastede. test street name 1. test additional info 1.
Wiefelstede. test street name 2. test additional info 2.

Hunte Report:  So., 11.10.2015

--------

Zusteller
Rastede. test street name 1. test additional info 1.

Frieslander Bote:  Di., 06.10.2015;  Di., 13.10.2015;  Di., 20.10.2015;  Di., 27.10.2015
Hunte Report:  So., 18.10.2015

--------

Zusteller
Wiefelstede. test street name 2. test additional info 2.

NWZ Ammerländer Nachrichten:  Sa., 03.10.2015;  Sa., 10.10.2015;  Sa., 17.10.2015

----------------
----------------

So first we split by (job_id  newspaper_id  placement_date)
then get locations combination for each item
then re-split by (job_id  combination_id)
and for each item fiil info (newspaper_id  =>  dates array)

*/





$tmpItems = [];
foreach ($dataProvider->models as $model) {
    $key = $model->adNewspaper->ad->job_id .'_' .$model->adNewspaper->newspaper_id .'_' .$model->placement_date;
    $tmpItems[$key][] = $model;
}




// Return combination of all locations of all models
function getLocationCombination($models)
{
    $combination = [];
    foreach ($models as $model) {
        foreach ($model->adNewspaper->ad->adJobLocations as $adJobLocation) {
            $text = $adJobLocation->__toString();
            if (!in_array($text, $combination)) {
                $combination[] = $text;
            }
        }
    }

    // sort by text is needed to correct random order in adJobLocations for right comparison in findCombination()
    // else 2 same locations can be treated as different
    sort($combination);
    return $combination;
}

function findCombination($checkedCombination, $combinationArray)
{
    foreach ($combinationArray as $key => $combination) {
        if ($checkedCombination == $combination) {
            return $key;
        }
    }

    return null;
}



$resultItems = [];
$locationCombinations = [];
foreach ($tmpItems as $key => $models) {
    $combination = getLocationCombination($models);
    $combination_id = findCombination($combination, $locationCombinations);

    if ($combination_id === null) {
        $combination_id = count($locationCombinations);
        $locationCombinations[] = $combination;
    }


    // we can use $models[0] here because job_id presents in $key, so $models have the same job_id
    $ad = $models[0]->adNewspaper->ad;
    $mainKey = $ad->job_id .'_'. $combination_id;
    if (!isset($resultItems[$mainKey])) {
        $item = [
            'mainKey' => $mainKey,
            'job' => $ad->job,
            'locations' => $combination,
            'newspapers_dates' => [],
        ];
    } else {
        $item = $resultItems[$mainKey];
    }

    foreach ($models as $dateModel) {
        $newspaper_id = $dateModel->adNewspaper->newspaper_id;
        if (!isset($item['newspapers_dates'][$newspaper_id])) {
            $item['newspapers_dates'][$newspaper_id] = [
                'newspaper' => $dateModel->adNewspaper->newspaper,
                'dates' => [],
            ];
        }

        $item['newspapers_dates'][$newspaper_id]['dates'][$dateModel->placement_date] = $dateModel->__toString();
    }

    $resultItems[$mainKey] = $item;
}

// sort by count of locations desc
uasort($resultItems, function($a, $b) {
    if (count($a['locations']) > count($b['locations'])) return -1;
    if (count($a['locations']) < count($b['locations'])) return 1;

    // equivalent elements are sorted by key to prevent random order
    return strcmp($a['mainKey'], $b['mainKey']);
});

?>

<div class="export-item-index">
    <?php
        foreach ($resultItems as $item) {
            echo $this->render('_export_item', ['item' => $item]);
        }
    ?>
</div>
