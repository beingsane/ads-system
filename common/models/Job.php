<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $job_name
 *
 * @property Ad[] $ads
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_name'], 'required'],
            [['job_name'], 'string', 'max' => 1000]
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
                    'ad' => ['column' => 'id', 'foreignColumn' => 'job_id'],
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
            'job_name' => Yii::t('app', 'Job Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ad::className(), ['job_id' => 'id']);
    }
}
