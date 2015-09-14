<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ExportItem;

/**
 * ExportItemSearch represents the model behind the search form about `\common\models\ExportItem`.
 */
class ExportItemSearch extends ExportItem
{
    public $date_from;
    public $date_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'safe'],
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
        $query = ExportItem::find();
        $query->joinWith(['adNewspaper']);
        $query->joinWith(['adNewspaper.ad']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['placement_date' => SORT_ASC]],
        ]);

        $loaded = $this->load($params);
        if (!$loaded) {
            $this->date_from = date('Y-m-d');
            $this->date_to = date('Y-m-d');
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            '>=', 'placement_date', $this->date_from
        ]);
        $query->andFilterWhere([
            '<=', 'placement_date', $this->date_to
        ]);
        $query->andWhere([
            'ad.deleted_at' => null
        ]);

        return $dataProvider;
    }
}
