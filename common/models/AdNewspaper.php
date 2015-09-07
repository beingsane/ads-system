<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_newspaper".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property string $newspaper_name
 *
 * @property Ad $ad
 * @property AdNewspaperPlacementDate[] $adNewspaperPlacementDates
 */
class AdNewspaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_newspaper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'newspaper_name'], 'required'],
            [['ad_id'], 'integer'],
            [['newspaper_name'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
            'newspaper_name' => Yii::t('app', 'Newspaper Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ad::className(), ['id' => 'ad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspaperPlacementDates()
    {
        return $this->hasMany(AdNewspaperPlacementDate::className(), ['ad_newspaper_id' => 'id'])->orderBy('placement_date');
    }
}
