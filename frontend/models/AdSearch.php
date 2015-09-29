<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Ad;

/**
 * AdSearch represents the model behind the search form about `\frontend\models\Ad`.
 */
class AdSearch extends Ad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_id'], 'integer'],
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ad.id' => $this->id,
            'ad.job_id' => $this->job_id,
            'ad.created_at' => $this->created_at,
            'ad.updated_at' => $this->updated_at,
            'ad.deleted_at' => $this->deleted_at,
        ]);

        // only ads of current user
        $query->andWhere(['ad.user_id' => Yii::$app->user->id]);

        // only active ads
        $query->andWhere(['ad.deleted_at' => null]);

        return $dataProvider;
    }
}
