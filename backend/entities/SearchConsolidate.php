<?php

namespace backend\entities;

use vizitm\entities\building\Building;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\db\Query;

class SearchConsolidate extends Building
{
    /**
     * @var mixed|null
     */

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ArrayDataProvider
     * @throws Exception
     */
    public function search(array $params): ArrayDataProvider
    {
        $query = (new Query())->select([
            't1.id, t1.address, 
            SUM(t2.deleted is null) totalRequest, 
            SUM((t2.status=1 or t2.status=4) and t2.deleted is null) newRequest,
            SUM((t2.status=2 or t2.status=5) and t2.deleted is null) workRequest,
            SUM(t2.status=3 and t2.deleted is null) doneRequest'
        ])
            ->from(['building t1'])
            ->join('INNER JOIN', 'request t2', '`t1`.`id` = `t2`.`building_id`')
            ->groupBy(['t1.id']);
        if(!empty($params['SearchConsolidate']['id']))
            $query->where(['t1.street_id' => $params['SearchConsolidate']['id']]);


        $command = $query->createCommand();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $command->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);



        //$dataProvider = new ActiveDataProvider([
        //    'query' => $query,
            //'Pagination' => [
                //'forcePageParam' => false,
                //'pageSizeParam' => false,
                //'pageParam' => 'active',
                //'pageSize' => 9,
            //],

            /*'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]*/
        //]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'                                    => $this->id,
        ]);


       // $query->andFilterWhere(['like', 'description', $this->description])
       //     //->andFilterWhere(['like', 'type', $this->type])
       //     ->andFilterWhere(['like', 'description_done', $this->description_done])
       //     ->andFilterWhere(['>=', 'created_at', $this->created_start ? strtotime($this->created_start . ' 00:00:00') : null])
       //     ->andFilterWhere(['<=', 'created_at', $this->created_end ? strtotime($this->created_end . ' 23:59:59') : null])
       //     ->andFilterWhere(['>=', 'done_at', $this->done_start ? strtotime($this->done_start . ' 00:00:00') : null])
       //     ->andFilterWhere(['<=', 'done_at', $this->done_end ? strtotime($this->done_end . ' 23:59:59') : null]);
        return $dataProvider;
    }
}