<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_newspaper_placement_date".
 *
 * @property integer $id
 * @property integer $ad_newspaper_id
 * @property string $placement_date
 *
 * @property AdNewspaper $adNewspaper
 */
class AdNewspaperPlacementDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_newspaper_placement_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_newspaper_id', 'placement_date'], 'required'],
            [['ad_newspaper_id'], 'integer'],
            [['placement_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ad_newspaper_id' => Yii::t('app', 'Ad Newspaper ID'),
            'placement_date' => Yii::t('app', 'Placement Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspaper()
    {
        return $this->hasOne(AdNewspaper::className(), ['id' => 'ad_newspaper_id']);
    }
}
