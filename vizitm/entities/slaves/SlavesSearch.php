<?php

namespace vizitm\entities\slaves;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StreetSearch represents the model behind the search form of `vizitm\entities\slaves\Slaves`.
 */
class SlavesSearch extends Slaves
{


    public function attributeLabels(): array
    {
        return [
            'master_id'                     => 'Начальник',
            'slave_id'                      => 'Подчиненый',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'master_id', 'slave_id'], 'integer'],
        ];
    }
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Slaves::find()->joinWith(['users']);
        $query->andFilterWhere( ['master_id' => ['master_id' => Yii::$app->user->getId()]]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_id' => $this->master_id
        ]);

        return $dataProvider;
    }
}
