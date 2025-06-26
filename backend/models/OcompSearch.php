<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ocomp;

/**
 * OcompSearch represents the model behind the search form of `backend\models\Ocomp`.
 */
class OcompSearch extends Ocomp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'noc', 'idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'subtotal', 'neto', 'iva', 'total'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = Ocomp::find();

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
            'noc' => $this->noc,
            'idtop' => $this->idtop,
            'idvop' => $this->idvop,
            'idreq' => $this->idreq,
            'iduser' => $this->iduser,
            'idprovider' => $this->idprovider,
            'subtotal' => $this->subtotal,
            'neto' => $this->neto,
            'iva' => $this->iva,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
