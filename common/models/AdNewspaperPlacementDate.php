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
            [['placement_date'], 'required'],
            [['placement_date'], 'checkPaperDate'],
        ];
    }

    public function checkPaperDate($attribute, $params)
    {
        $value = $this->$attribute;
        $dayOfWeek = date('N', strtotime($value));

        $publishDays = $this->adNewspaper->newspaper->publishDays;
        if (isset($publishDays[$dayOfWeek]) && $publishDays[$dayOfWeek] == 1) {
            return true;
        }

        $this->addError($attribute, Yii::t('app', 'This date is not allowed for this paper'));
        return false;
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

    public function __toString()
    {
        return ($this->placement_date ? Yii::$app->formatter->asDate($this->placement_date) : '');
    }
}
