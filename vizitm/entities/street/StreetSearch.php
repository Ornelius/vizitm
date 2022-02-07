<?php

namespace vizitm\entities\building\street;

use vizitm\entities\Users;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vizitm\entities\street\Street;

/**
 * StreetSearch represents the model behind the search form of `vizitm\entities\street\Street`.
 */
class StreetSearch extends Model
{
    public $id;
    public $street;


    public function attributeLabels()
    {
        return [
            'street'                         => 'Название улицы',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['street'], 'safe'],
           // [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d']
        ];
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
        $query = Street::find();

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

        if($user = Users::findByUsername($this->created_by)){
            $this->created_by = $user->id;
        }
        // grid filtering conditions
        $query->andFilterWhere(['like', 'street', $this->name])
            //->andFilterWhere(['=', 'created_by', $this->created_by])
            //->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            //->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
        ;
//print_r($dataProvider);die();
        return $dataProvider;
    }
}
