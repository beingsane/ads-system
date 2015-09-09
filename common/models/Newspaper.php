<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "newspaper".
 *
 * @property integer $id
 * @property string $newspaper_name
 *
 * @property AdNewspaper[] $adNewspapers
 */
class Newspaper extends \yii\db\ActiveRecord
{
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
            'newspaper_name' => Yii::t('app', 'Newspaper Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspapers()
    {
        return $this->hasMany(AdNewspaper::className(), ['newspaper_id' => 'id']);
    }
}
