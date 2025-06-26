<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Squote;

/**
 * SquoteSearch represents the model behind the search form of `backend\models\Squote`.
 */
class SquoteSearch extends Squote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mc', 'subtotal', 'gg', 'neto', 'iva', 'total', 'accepted', 'author_accepted', 'approved_f', 'approved_c', 'idreq', 'idpquote'], 'integer'],
            [['cmp'], 'number'],
            [['created_at', 'date_accepted'], 'safe'],
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
        $query = Squote::find();

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
            'mc' => $this->mc,
            'cmp' => $this->cmp,
            'subtotal' => $this->subtotal,
            'gg' => $this->gg,
            'neto' => $this->neto,
            'iva' => $this->iva,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'accepted' => $this->accepted,
            'author_accepted' => $this->author_accepted,
            'date_accepted' => $this->date_accepted,
            'approved_f' => $this->approved_f,
            'approved_c' => $this->approved_c,
            'idreq' => $this->idreq,
            'idpquote' => $this->idpquote,
        ]);

        return $dataProvider;
    }
}
