<?php
namespace vizitm\entities\comments;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StreetSearch represents the model behind the search form of `vizitm\entities\slaves\Slaves`.
 */
class CommentsSearch extends Comments
{

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = self::find()->joinWith(['users', 'request']);
        $query->andFilterWhere(['user_id' => ['user_id' => Yii::$app->user->getId()]]);
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
            'request_id' => $this->user_id
        ]);

        return $dataProvider;
    }
}