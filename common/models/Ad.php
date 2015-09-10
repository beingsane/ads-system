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
    
    
    
    public function loadRelation($mainModel, $relationName, $relatedModelClassName, $data)
    {
        $loaded = true;
        $models = [];
        
        $stub = new $relatedModelClassName;
        $formName = $stub->formName();
        unset($stub);
        
        if (isset($data[$formName])) {
            foreach ($data[$formName] as $modelData) {
                if (isset($modelData['id'])) {
                    $model = $relatedModelClassName::findOne($modelData['id']);
                    
                    if (!$model) {
                        unset($modelData['id']);
                        $model = new $relatedModelClassName();
                    }
                } else {
                    $model = new $relatedModelClassName();
                }
                
                $currentModelLoaded = $model->load([$formName => $modelData]);
                if (!$currentModelLoaded) $loaded = false;
                
                $models[] = $model;
            }
            $mainModel->populateRelation($relationName, $models);
        } else {
            $loaded = false;
        }
        return $loaded;
    }
    
    public function loadWithRelations($data)
    {
        $loaded = true;
        do {
            $itemLoaded = $this->load($data);
            $loaded = $loaded && $itemLoaded;
            if (!$loaded) break;
            
            $itemLoaded = $this->loadRelation($this, 'adJobLocations', AdJobLocation::className(), $data);
            $loaded = $loaded && $itemLoaded;
            
            $itemLoaded = $this->loadRelation($this, 'adNewspapers', AdNewspaper::className(), $data);
            $loaded = $loaded && $itemLoaded;
            
            $stub = new AdNewspaperPlacementDate();
            $formName = $stub->formName();
            unset($stub);
            
            foreach ($this->adNewspapers as $i => $adNewspaper) {
                if (isset($data[$formName][$i])) {
                    $itemLoaded = $this->loadRelation($adNewspaper, 'adNewspaperPlacementDates',
                        AdNewspaperPlacementDate::className(),
                        [$formName => $data[$formName][$i]]
                    );
                } else {
                    $itemLoaded = true;
                }
                
                $loaded = $loaded && $itemLoaded;
            }
        }
        while (false);
        
        return $loaded;
    }
    
    public function validateWithRelations()
    {
        $validated = true;
        do {
            $itemValidated = $this->validate();
            $validated = $validated && $itemValidated;
            
            $itemValidated = self::validateMultiple($this->adJobLocations);
            $validated = $validated && $itemValidated;
            
            $itemValidated = self::validateMultiple($this->adNewspapers);
            $validated = $validated && $itemValidated;
            
            foreach ($this->adNewspapers as $i => $adNewspaper) {
                $itemValidated = self::validateMultiple($adNewspaper->adNewspaperPlacementDates);
                $validated = $validated && $itemValidated;
            }
        }
        while (false);
        
        return $validated;
    }
    
    public function saveWithRelations()
    {
        ;
    }
}
