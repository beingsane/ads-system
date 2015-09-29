<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ad;

/**
 * AdSearch represents the model behind the search form about `\common\models\Ad`.
 */
class AdSearch extends Ad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'job_id'], 'integer'],
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
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['job'] = [
            'asc' => ['job.job_name' => SORT_ASC],
            'desc' => ['job.job_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['status'] = [
            'asc' => ['ad.deleted_at' => SORT_ASC],
            'desc' => ['ad.deleted_at' => SORT_DESC],
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
            'ad.user_id' => $this->user_id,
            'ad.created_at' => $this->created_at,
            'ad.updated_at' => $this->updated_at,
            'ad.deleted_at' => $this->deleted_at,
        ]);

        return $dataProvider;
    }
}
