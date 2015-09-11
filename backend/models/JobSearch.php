<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Job;
use yii\helpers\ArrayHelper;

/**
 * JobSearch represents the model behind the search form about `\common\models\Job`.
 */
class JobSearch extends Job
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['job_name', 'deleted_at'], 'safe'],
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
        $query = Job::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'job_name', $this->job_name]);

        return $dataProvider;
    }
    
    public static function jobList($active = true, $deleted = false)
    {
        $query = Job::find();
        
        if (!$active && !$deleted) {
            return [];
        }
        
        if ($active && !$deleted) {
            $query->where(['deleted_at' => null]);
        } else if ($deleted && !$active) {
            $query->where(['not' => ['deleted_at' => null]]);
        }
        
        $jobs = $query->all();
        $res = ArrayHelper::map($jobs, 'id', 'job_name');
        
        return $res;
    }
}
