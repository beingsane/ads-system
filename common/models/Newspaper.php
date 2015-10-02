<?php

namespace common\models;

use Yii;
use common\traits\StatusTrait;

/**
 * This is the model class for table "newspaper".
 *
 * @property integer $id
 * @property string $newspaper_name
 * @property string $publish_days
 *
 * @property AdNewspaper[] $adNewspapers
 */
class Newspaper extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    use StatusTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newspaper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newspaper_name'], 'required'],
            [['newspaper_name'], 'string', 'max' => 1000],
            [['publishDays'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \common\behaviors\SoftDeleteBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
                'type' => \common\behaviors\SoftDeleteBehavior::HARD_SOFT_TYPE,
                'relatedTables' => [
                    'ad_newspaper' => ['column' => 'id', 'foreignColumn' => 'newspaper_id'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'newspaper_name' => Yii::t('app', 'Newspaper Name'),
            'publishDays' => Yii::t('app', 'Publish days'),
            'statusHtml' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspapers()
    {
        return $this->hasMany(AdNewspaper::className(), ['newspaper_id' => 'id']);
    }

    /**
     * To avoid creating separate table for publish days of newspaper we store it as array serialized to string
     */
    public function getPublishDays()
    {
        if ($this->publish_days === null) $value = [];
        else $value = unserialize($this->publish_days);
        if (!is_array($value)) $value = [];
        return $value;
    }

    public function setPublishDays($value)
    {
        if (!is_array($value) || empty($value)) $value = null;
        $this->publish_days = serialize($value);
    }

    public function getPublishDaysText($html = true)
    {
        $publishDaysList = self::publishDaysList();
        $publishDays = [];
        foreach ($this->publishDays as $day => $isPublished) {
            if ($isPublished) {
                $publishDays[] = $publishDaysList[$day];
            }
        }

        if ($publishDays) $text = implode("\n", $publishDays);
        else $text = Yii::t('app', 'Not published');

        if ($html) $text = nl2br($text);
        return $text;
    }

    public static function publishDaysList()
    {
        // assume that in all locales first day of week is monday
        return [
            1 => Yii::t('app', 'Monday'),
            2 => Yii::t('app', 'Tuesday'),
            3 => Yii::t('app', 'Wednesday'),
            4 => Yii::t('app', 'Thursday'),
            5 => Yii::t('app', 'Friday'),
            6 => Yii::t('app', 'Saturday'),
            7 => Yii::t('app', 'Sunday'),
        ];
    }
}
