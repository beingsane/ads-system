<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_newspaper".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property integer $newspaper_id
 *
 * @property Newspaper $newspaper
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
            [['newspaper_id'], 'required'],
            [['newspaper_id'], 'integer']
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
            'newspaper_id' => Yii::t('app', 'Newspaper ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewspaper()
    {
        return $this->hasOne(Newspaper::className(), ['id' => 'newspaper_id']);
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
        return $this->hasMany(AdNewspaperPlacementDate::className(), ['ad_newspaper_id' => 'id']);
    }
    
    public function validate($attributeNames = NULL, $clearErrors = true)
    {
        $res = parent::validate($attributeNames, $clearErrors);
        
        $attribute = 'adNewspaperPlacementDates';
        if (empty($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'You have to add at least one placement date'));
            $res = false;
        }
        
        return $res;
    }
}
