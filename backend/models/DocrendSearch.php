<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Docrend;

/**
 * DocrendSearch represents the model behind the search form of `backend\models\Docrend`.
 */
class DocrendSearch extends Docrend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idreq', 'assigned_amount', 'expended_amount', 'difference', 'total', 'idsolicitor', 'qty_boletas', 'qty_peajes', 'qty_facturas', 'qty_nc', 'tot_boletas', 'tot_facturas', 'tot_nc', 'tot_peajes', 'detail_count'], 'integer'],
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
        $query = Docrend::find();

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
            'assigned_amount' => $this->assigned_amount,
            'expended_amount' => $this->expended_amount,
            'difference' => $this->difference,
            'total' => $this->total,
            'idsolicitor' => $this->idsolicitor,
            'qty_boletas' => $this->qty_boletas,
            'qty_peajes' => $this->qty_peajes,
            'qty_facturas' => $this->qty_facturas,
            'qty_nc' => $this->qty_nc,
            'tot_boletas' => $this->tot_boletas,
            'tot_facturas' => $this->tot_facturas,
            'tot_nc' => $this->tot_nc,
            'tot_peajes' => $this->tot_peajes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'detail_count' => $this->detail_count,
        ]);

        return $dataProvider;
    }
}
