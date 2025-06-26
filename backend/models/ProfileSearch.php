<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form of `backend\models\Profile`.
 */
class ProfileSearch extends Profile
{
	public $roleName;
	public $eMail;
	public $created_from;
	public $created_to;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iduser', 'idrole'], 'integer'],
            [['name', 'lastname', 'created_at', 'updated_at', 'roleName', 'eMail', 'created_from', 'created_to'], 'safe'],
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
        $query = Profile::find()->joinWith(['role', 'user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		
		# Custom fields
		$dataProvider->sort->attributes['roleName'] = [
		    'asc' => ['role.name' => SORT_ASC],
		    'desc' => ['role.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['eMail'] = [
		    'asc' => ['user.email' => SORT_ASC],
		    'desc' => ['user.email' => SORT_DESC],
		];
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		if (!empty($this->created_from)) {
		    $query->andWhere(['>=', 'profile.created_at', $this->created_from . ' 00:00:00']);
		}
		
		if (!empty($this->created_to)) {
		    $query->andWhere(['<=', 'profile.created_at', $this->created_to . ' 23:59:59']);
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'iduser' => $this->iduser,
            'idrole' => $this->idrole,
            'profile.created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'role.name', $this->roleName])	
            ->andFilterWhere(['like', 'user.email', $this->eMail])
			->andFilterWhere(['like', 'DATE(profile.created_at)', $this->created_at]);

        return $dataProvider;
    }
}
