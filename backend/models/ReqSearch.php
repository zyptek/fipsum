<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Req;
use yii\db\Expression;


/**
 * ReqSearch represents the model behind the search form of `backend\models\Req`.
 */
class ReqSearch extends Req
{
	public $companyBranch;
#	public $companyCol;
	public $statusCol;
	public $kamCol;
	public $tosCol;
	public $activityCol;
	public $solicitorCol;
	public $estdaysCol;
	public $createdCol;
	public $timeCol;
	public $pquoteCount;
	public $created_from;
	public $created_to;
	
	
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estdays', 'idactivity', 'idtos', 'idstatus', 'idkam', 'idbranch', 'idsolicitor','pquoteCount',], 'integer'],
            [['idalt', 'inidetail', 'description', 'created_at', 'companyBranch', 'statusCol', 'kamCol', 'tosCol', 'activityCol', 'solicitorCol', 'estdaysCol', 'createdCol', 'timeCol', 'created_from', 'created_to',], 'safe'],
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
        $query = Req::find()->joinWith(['company', 'branch', 'status', 'profile', 'tos', 'activity', 'solicitor', 'pquotes']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$this->load($params);
		
		# Custom fields
/*
		$dataProvider->sort->attributes['companyCol'] = [
		    'asc' => ['company.alias' => SORT_ASC],
		    'desc' => ['company.alias' => SORT_DESC],
		];
*/
		$dataProvider->sort->attributes['statusCol'] = [
		    'asc' => ['status.name' => SORT_ASC],
		    'desc' => ['status.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['kamCol'] = [
		    'asc' => [
		        'profile.name' => SORT_ASC,
		        'profile.lastname' => SORT_ASC,
		    ],
		    'desc' => [
		        'profile.name' => SORT_DESC,
		        'profile.lastname' => SORT_DESC,
		    ],
		    'default' => SORT_ASC,
		];
		$dataProvider->sort->attributes['tosCol'] = [
		    'asc' => ['status.name' => SORT_ASC],
		    'desc' => ['status.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['activityCol'] = [
		    'asc' => ['company.alias' => SORT_ASC],
		    'desc' => ['company.alias' => SORT_DESC],
		];
		$dataProvider->sort->attributes['solicitorCol'] = [
		    'asc' => ['status.name' => SORT_ASC],
		    'desc' => ['status.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['estdaysCol'] = [
		    'asc' => ['company.alias' => SORT_ASC],
		    'desc' => ['company.alias' => SORT_DESC],
		];
		$dataProvider->sort->attributes['createdCol'] = [
		    'asc' => ['status.name' => SORT_ASC],
		    'desc' => ['status.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['timeCol'] = [
		    'asc' => ['company.alias' => SORT_ASC],
		    'desc' => ['company.alias' => SORT_DESC],
		];

        $dataProvider->sort->attributes['companyBranch'] = [
		    'asc' => [
		        'company.alias' => SORT_ASC,
		        'branch.name' => SORT_ASC,
		    ],
		    'desc' => [
		        'company.alias' => SORT_DESC,
		        'branch.name' => SORT_DESC,
		    ],
		    'default' => SORT_ASC,
		];
		$dataProvider->sort->attributes['pquoteCount'] = [
		    'asc' => ['(SELECT COUNT(*) FROM pquote WHERE pquote.idreq = req.id)' => SORT_ASC],
		    'desc' => ['(SELECT COUNT(*) FROM pquote WHERE pquote.idreq = req.id)' => SORT_DESC],
		];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            # $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['or',
		    ['like', 'company.alias', $this->companyBranch],
		    ['like', 'branch.name', $this->companyBranch],
		]);
		$query->andFilterWhere(['or',
		    ['like', 'profile.name', $this->kamCol],
		    ['like', 'profile.lastname', $this->kamCol],
		]);
		$query->andFilterWhere(['=', '(SELECT COUNT(*) FROM pquote WHERE pquote.idreq = req.id)', $this->pquoteCount]);
		if (!empty($this->created_from)) {
		    $query->andWhere(['>=', 'profile.created_at', $this->created_from . ' 00:00:00']);
		}
		
		if (!empty($this->created_to)) {
		    $query->andWhere(['<=', 'profile.created_at', $this->created_to . ' 23:59:59']);
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'req.id' => $this->id,
            'req.estdays' => $this->estdays,
#            'req.idactivity' => $this->idactivity,
#            'req.idtos' => $this->idtos,
#            'req.idstatus' => $this->idstatus,
#            'req.idkam' => $this->idkam,
#            'req.idbranch' => $this->idbranch,
#            'req.idsolicitor' => $this->idsolicitor,
            'req.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'req.nst', $this->nst])
            ->andFilterWhere(['like', 'req.inidetail', $this->inidetail])
            ->andFilterWhere(['like', 'req.description', $this->description])
#            ->andFilterWhere(['like', 'company.alias', $this->companyCol])
            ->andFilterWhere(['like', 'status.name', $this->statusCol])
#            ->andFilterWhere(['like', 'profile.name', $this->kamCol])
            ->andFilterWhere(['like', 'tos.name', $this->tosCol])
            ->andFilterWhere(['like', 'activity.name', $this->activityCol])
            ->andFilterWhere(['like', 'solicitor.name', $this->solicitorCol]);
#            ->andFilterWhere(['like', 'req', $this->timeCol])
#            ->andFilterWhere(['like', 'req', $this->cotiCol]);
		
		\Yii::INFO($dataProvider->sort->attributes, 'NUTZO');
		
        return $dataProvider;
    }
}
