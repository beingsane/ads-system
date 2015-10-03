<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ExportItem;
use yii\helpers\ArrayHelper;

/**
 * ExportItemSearch represents the model behind the search form about `\common\models\ExportItem`.
 */
class ExportItemSearch extends ExportItem
{
    public $date_from;
    public $date_to;
    public $job_id;
    public $newspaper_id;
    public $id;
    public $text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_id', 'newspaper_id'], 'integer'],
            [['date_from', 'date_to'], 'safe'],
            [['id', 'text'], 'string', 'max' => '100'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'newspaper_id' => Yii::t('app', 'Newspaper edition'),
            'job_id' => Yii::t('app', 'Job'),
            'date_from' => Yii::t('app', 'Date from'),
            'date_to' => Yii::t('app', 'Date to'),
            'text' => Yii::t('app', 'Text'),
            'id' => Yii::t('app', 'Ad ID'),
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $allModels = false)
    {
        $query = ExportItem::find();
        $query->joinWith(['adNewspaper']);
        $query->joinWith(['adNewspaper.ad']);
        $query->joinWith(['adNewspaper.ad.job']);
        $query->joinWith(['adNewspaper.newspaper']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['placement_date' => SORT_ASC]],
            'pagination' => [
                'pageSize' => ($allModels ? 0 : 4),
            ],
        ]);


        $dataProvider->sort->attributes['adNewspaper.ad.job.job_name'] = [
            'asc' => ['job.job_name' => SORT_ASC],
            'desc' => ['job.job_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['adNewspaper.newspaper.newspaper_name'] = [
            'asc' => ['newspaper.newspaper_name' => SORT_ASC],
            'desc' => ['newspaper.newspaper_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['adNewspaper.ad.id'] = [
            'asc' => ['ad.id' => SORT_ASC],
            'desc' => ['ad.id' => SORT_DESC],
        ];

        $loaded = $this->load($params);
        if (!$loaded) {
            // set default filter
            $this->date_from = date('Y-m-d');
            $this->date_to = date('Y-m-d');
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['>=', 'placement_date', $this->date_from]);
        $query->andFilterWhere(['<=', 'placement_date', $this->date_to]);

        $query->andFilterWhere(['ad_newspaper.newspaper_id' => $this->newspaper_id]);
        $query->andFilterWhere(['ad.job_id' => $this->job_id]);
        $query->andFilterWhere(['ad.id' => $this->id]);


        if ($this->text) {
            $subQueryText = \common\models\AdJobLocation::find();
            $subQueryText->where(['=', 'ad_newspaper.ad_id', new \yii\db\Expression('ad.id')]);
            $subQueryText->andFilterWhere(['or',
                ['like', 'job_location', $this->text],
                ['like', 'street_names', $this->text],
                ['like', 'additional_info', $this->text],
            ]);
            $subQueryText->limit(1);

            $query->andFilterWhere(['exists', $subQueryText]);
        };

        //echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql; die;

        //$query->andWhere(['ad.deleted_at' => null]);

        return $dataProvider;
    }
}
