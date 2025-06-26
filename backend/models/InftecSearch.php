<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Inftec;

/**
 * InftecSearch represents the model behind the search form of `backend\models\Inftec`.
 */
class InftecSearch extends Inftec
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idreq'], 'integer'],
            [['detalle', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Inftec::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idreq' => $this->idreq,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'detalle', $this->detalle]);

        return $dataProvider;
    }
}
