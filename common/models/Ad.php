<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User;
use common\traits\StatusTrait;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $job_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Job $job
 * @property AdJobLocation[] $adJobLocations
 * @property AdNewspaper[] $adNewspapers
 * @property User $user
 */
class Ad extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';
    use StatusTrait;


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
            [['job_id'], 'required'],
            [['job_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'SoftDeleteBehavior' => [
                'class' => \common\behaviors\SoftDeleteBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
                'type' => \common\behaviors\SoftDeleteBehavior::HARD_TYPE,
            ],
            'BlameableBehavior' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
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
            'job_id' => Yii::t('app', 'Job'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),

            'adJobLocations' => Yii::t('app', 'Job locations'),
            'adNewspapers' => Yii::t('app', 'Newspapers'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdJobLocations()
    {
        return $this->hasMany(AdJobLocation::className(), ['ad_id' => 'id'])->orderBy('id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdNewspapers()
    {
        return $this->hasMany(AdNewspaper::className(), ['ad_id' => 'id'])->orderBy('id');
    }



    public function loadRelation($mainModel, $relationName, $parentRelationName, $relatedModelClassName, $data)
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

                $model->populateRelation($parentRelationName, $mainModel);
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

            $itemLoaded = $this->loadRelation($this, 'adJobLocations', 'ad', AdJobLocation::className(), $data);
            $loaded = $loaded && $itemLoaded;

            $itemLoaded = $this->loadRelation($this, 'adNewspapers', 'ad', AdNewspaper::className(), $data);
            $loaded = $loaded && $itemLoaded;

            $stub = new AdNewspaperPlacementDate();
            $formName = $stub->formName();
            unset($stub);

            foreach ($this->adNewspapers as $i => $adNewspaper) {
                if (isset($data[$formName][$i])) {
                    $itemLoaded = $this->loadRelation($adNewspaper, 'adNewspaperPlacementDates', 'adNewspaper',
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

            $itemValidated = static::validateMultiple($this->adJobLocations);
            $validated = $validated && $itemValidated;

            foreach ($this->adNewspapers as $i => $adNewspaper) {
                $itemValidated = static::validateMultiple($adNewspaper->adNewspaperPlacementDates);
                $validated = $validated && $itemValidated;
            }

            $itemValidated = static::validateMultiple($this->adNewspapers);
            $validated = $validated && $itemValidated;
        }
        while (false);

        return $validated;
    }

    public function getModel($id, $className)
    {
        if ($id) {
            $model = $className::findOne($id);
        } else {
            $model = new $className();
        }

        return $model;
    }

    public function deleteRelations($oldModels, $newModels, $modelClassName)
    {
        $oldIDs = ArrayHelper::map($oldModels, 'id', 'id');
        $newIDs = ArrayHelper::map($newModels, 'id', 'id');
        $deletedIDs = array_filter(array_diff($oldIDs, $newIDs));

        if (!empty($deletedIDs)) {
            // it does not delete inner relations so it is needed to setup cascade deletion
            // in foreign key settings in database
            $modelClassName::deleteAll(['id' => $deletedIDs]);
        }
    }

    public function saveWithRelations()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $saved = false;
        try {
            do {
                // we need to reload model because we need to get all previous relations
                $oldModel = $this->getModel($this->id, static::className());


                $saved = $this->save(false);
                if (!$saved) break;

                $ad_id = $this->id;


                $this->deleteRelations($oldModel->adJobLocations, $this->adJobLocations, AdJobLocation::className());
                foreach ($this->adJobLocations as $modelLocation) {
                    $modelLocation->ad_id = $ad_id;
                    $saved = $modelLocation->save(false);
                    if (!$saved) break;
                }
                if (!$saved) break;



                $this->deleteRelations($oldModel->adNewspapers, $this->adNewspapers, AdNewspaper::className());
                foreach ($this->adNewspapers as $modelNewspaper) {
                    $oldModelNewspaper = $this->getModel($modelNewspaper->id, AdNewspaper::className());

                    $modelNewspaper->ad_id = $ad_id;
                    $saved = $modelNewspaper->save(false);
                    if (!$saved) break;

                    $ad_newspaper_id = $modelNewspaper->id;


                    $this->deleteRelations($oldModelNewspaper->adNewspaperPlacementDates,
                        $modelNewspaper->adNewspaperPlacementDates,
                        AdNewspaperPlacementDate::className()
                    );
                    foreach ($modelNewspaper->adNewspaperPlacementDates as $modelPlacementDate) {
                        $modelPlacementDate->ad_newspaper_id = $ad_newspaper_id;
                        $saved = $modelPlacementDate->save(false);
                        if (!$saved) break;
                    }
                    if (!$saved) break;
                }
                if (!$saved) break;


                $saved = true;
            } while(false);

        } catch (\yii\db\Exception $e) {
            Yii::error($e->getMessage());
            $message = (YII_DEBUG ? $e->getMessage() : 'Error occured while saving in database');
            Yii::$app->session->setFlash('error', $message);

            $saved = false;
        }

        if ($saved) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }

        return $saved;
    }
}
