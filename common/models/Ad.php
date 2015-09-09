<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $job_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Job $job
 * @property AdJobLocation[] $adJobLocations
 * @property AdNewspaper[] $adNewspapers
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'created_at', 'updated_at'], 'required'],
            [['job_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
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
            'job_id' => Yii::t('app', 'Job ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdJobLocations()
    {
        return $this->hasMany(AdJobLocation::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspapers()
    {
        return $this->hasMany(AdNewspaper::className(), ['ad_id' => 'id']);
    }
}
