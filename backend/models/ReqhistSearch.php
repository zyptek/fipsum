<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Reqhist;

/**
 * ReqhistSearch represents the model behind the search form of `backend\models\Reqhist`.
 */
class ReqhistSearch extends Reqhist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idreq', 'idhisttype', 'iduser'], 'integer'],
            [['detail', 'created_at'], 'safe'],
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
        $query = Reqhist::find();

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
            'idhisttype' => $this->idhisttype,
            'iduser' => $this->iduser,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
