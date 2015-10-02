<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Newspaper;
use yii\helpers\ArrayHelper;

/**
 * NewspaperSearch represents the model behind the search form about `\common\models\Newspaper`.
 */
class NewspaperSearch extends Newspaper
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['newspaper_name', 'deleted_at'], 'safe'],
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
        $query = Newspaper::find();

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

        $query->andFilterWhere(['like', 'newspaper_name', $this->newspaper_name]);

        return $dataProvider;
    }


    public static function newspaperList($active = true, $deleted = false)
    {
        $query = Newspaper::find();

        if (!$active && !$deleted) {
            return [];
        }

        if ($active && !$deleted) {
            $query->where(['deleted_at' => null]);
        } else if ($deleted && !$active) {
            $query->where(['not' => ['deleted_at' => null]]);
        }

        $jobs = $query->all();
        $res = ArrayHelper::map($jobs, 'id', 'newspaper_name');

        return $res;
    }
}
