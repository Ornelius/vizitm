<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use vizitm\entities\Users;

/**
 * UsersSearch represents the model behind the search form of `vizitm\entities\Users`.
 */
class UsersSearch extends Model
{
    public $id;
    public $status;
    public $date_from;
    public $date_to;
    public $role;
    public $username;
    public $email;
    public $firstname;
    public $lastname;
    public $position;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'status', 'role', 'position'], 'integer'],
            [['username', 'email', 'firstname', 'lastname'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d']
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
        $query = Users::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'position' => $this->position
            //'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
        ;

        return $dataProvider;
    }
}
