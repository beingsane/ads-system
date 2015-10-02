<?php

namespace common\models;

use Yii;
use common\traits\StatusTrait;

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
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    use StatusTrait;

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
            'statusHtml' => Yii::t('app', 'Status'),
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
