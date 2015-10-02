<?php
namespace common\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class UrlHelper
{
    public static function remember()
    {
        Url::remember('', Yii::$app->controller->id);
    }

    public static function previous()
    {
        $url = Url::previous(Yii::$app->controller->id);
        if (!$url) $url = Url::toRoute([Yii::$app->controller->id.'/']);
        return $url;
    }

    public static function referer()
    {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $action = Yii::$app->controller->action;
            $id = Yii::$app->request->get('id', false);
            if ($action && $id && $action->id != 'delete') {
                $url = ['view', 'id' => $id];
            } else {
                $url = ['index'];
            }
        }

        return $url;
    }
}
