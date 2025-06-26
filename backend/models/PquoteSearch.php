<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pquote;

/**
 * PquoteSearch represents the model behind the search form of `backend\models\Pquote`.
 */
class PquoteSearch extends Pquote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idprovider', 'cost', 'idreq', 'selected'], 'integer'],
            [['created_at', 'description', 'activities', 'valunt', 'payopt', 'exedr', 'exehr', 'tac'], 'safe'],
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
        $query = Pquote::find();

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
            'idprovider' => $this->idprovider,
            'cost' => $this->cost,
            'created_at' => $this->created_at,
            'idreq' => $this->idreq,
            'selected' => $this->selected,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'activities', $this->activities])
            ->andFilterWhere(['like', 'valunt', $this->valunt])
            ->andFilterWhere(['like', 'payopt', $this->payopt])
            ->andFilterWhere(['like', 'exedr', $this->exedr])
            ->andFilterWhere(['like', 'exehr', $this->exehr])
            ->andFilterWhere(['like', 'tac', $this->tac]);

        return $dataProvider;
    }
}
