<?php

namespace frontend\models;

use Yii;

class Ad extends \common\models\Ad
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['SoftDeleteBehavior']['type'] = \common\behaviors\SoftDeleteBehavior::SOFT_TYPE;
        return $behaviors;
    }
}
