<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ad;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * AdSearch represents the model behind the search form about `\common\models\Ad`.
 */
class AdSearch extends Ad
{
    public $date_from;
    public $date_to;
    public $newspaper_id;
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'newspaper_id' => Yii::t('app', 'Newspaper edition'),
            'date_from' => Yii::t('app', 'Date from'),
            'date_to' => Yii::t('app', 'Date to'),
            'text' => Yii::t('app', 'Text'),
        ]);
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Ad::find();
        $query->joinWith(['job']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['job'] = [
            'asc' => ['job.job_name' => SORT_ASC],
            'desc' => ['job.job_name' => SORT_DESC],
        ];


        $sortQuery = "(
            SELECT newspaper_name
            FROM ad_newspaper
                INNER JOIN newspaper ON ad_newspaper.newspaper_id = newspaper.id
            WHERE ad_newspaper.ad_id = ad.id
            ORDER BY ad_newspaper.id
        )";

        $dataProvider->sort->attributes['newspaper_id'] = [
            'asc' => [$sortQuery => SORT_ASC],
            'desc' => [$sortQuery => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ad.id' => $this->id,
            'ad.job_id' => $this->job_id,
        ]);

        // only ads of current user
        //$query->andWhere(['ad.user_id' => Yii::$app->user->id]);
        //$query->andWhere(['ad.user_id1' => Yii::$app->user->id]);

        // only active ads
        //$query->andWhere(['ad.deleted_at' => null]);
//var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql); die;
        return $dataProvider;
    }
}
