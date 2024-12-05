<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Requerimiento;

/**
 * RequerimientoSearch represents the model behind the search form of `backend\models\Requerimiento`.
 */
class RequerimientoSearch extends Requerimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor'], 'integer'],
            [['idalt', 'inidetail', 'description', 'created_at'], 'safe'],
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
        $query = Requerimiento::find();

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
            'estdays' => $this->estdays,
            'idactivity' => $this->idactivity,
            'idtos' => $this->idtos,
            'idstatus' => $this->idstatus,
            'idkam' => $this->idkam,
            'idbranch' => $this->idbranch,
            'idsolicitor' => $this->idsolicitor,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'idalt', $this->idalt])
            ->andFilterWhere(['like', 'inidetail', $this->inidetail])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
