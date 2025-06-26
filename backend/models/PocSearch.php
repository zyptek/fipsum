<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Poc;

/**
 * PocSearch represents the model behind the search form of `backend\models\Poc`.
 */
class PocSearch extends Poc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idtop', 'idvop', 'idreq', 'iduser', 'idprovider', 'noc', 'subtotal', 'neto', 'iva', 'total'], 'integer'],
            [['descrip', 'created_at', 'updated_at'], 'safe'],
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
        $query = Poc::find();

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
            'idtop' => $this->idtop,
            'idvop' => $this->idvop,
            'idreq' => $this->idreq,
            'iduser' => $this->iduser,
            'idprovider' => $this->idprovider,
            'noc' => $this->noc,
            'subtotal' => $this->subtotal,
            'neto' => $this->neto,
            'iva' => $this->iva,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'descrip', $this->descrip]);

        return $dataProvider;
    }
}
