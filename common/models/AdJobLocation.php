<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_job_location".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property string $job_location
 * @property string $additional_info
 *
 * @property Ad $ad
 */
class AdJobLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_job_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'job_location'], 'required'],
            [['ad_id'], 'integer'],
            [['job_location', 'additional_info'], 'string', 'max' => 1000]
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
            'job_location' => Yii::t('app', 'Job Location'),
            'additional_info' => Yii::t('app', 'Additional Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ad::className(), ['id' => 'ad_id']);
    }
}
