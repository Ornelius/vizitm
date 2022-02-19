<?php

namespace vizitm\entities\request;

use vizitm\entities\Users;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchRequest represents the model behind the search form of `vizitm\entities\request\Request`.
 */
class SearchRequest extends Request
{
    public ?string $done_range      = null;
    public ?string $done_start      = null;
    public ?string $done_end        = null;
    public ?string $created_range   = null;
    public ?string $created_start   = null;
    public ?string $created_end     = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'building_id', 'user_id', 'created_at', 'deleted', 'deleted_at', 'done', 'done_at', 'invoice', 'invoce_at', 'type_of_work', 'type', 'due_date', 'room', 'work_whom'], 'integer'],
            [['description', 'description_done'], 'safe'],
            [['done_start', 'done_end', 'created_start', 'created_end'], 'date', 'format' => 'php:Y-m-d'],
            [['done_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['created_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $status
     * @return ActiveDataProvider
     */
    public function search(array $params, int $status): ActiveDataProvider
    {
        $position = Users::findUserByID(Yii::$app->user->getId())->position;

        $query = Request::find()->joinWith(['building','photo']);
        if($status === Request::STATUS_NEW) {
            $query->andFilterWhere([
                'status' => ['status' => Request::STATUS_NEW] /** Новая заявка **/
            ]);
        } elseif ($status === Request::STATUS_WORK) { /** Заявка в работе **/
            if(!(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR)))
                $query->andFilterWhere([
                    'work_whom' => ['work_whom' => Yii::$app->user->getId()] /** Фильтрация заявок по пользователю **/
                ]);
            $query->andFilterWhere([
                'status' => ['status' => Request::STATUS_WORK] /** Заявка в работе **/
            ]);
        } elseif ($status === Request::STATUS_DONE) { /** Выполненные заявки **/
            //if(!(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR)))
            //    $query->andFilterWhere([
            //        'work_whom' => ['work_whom' => Yii::$app->user->getId()] /** Фильтрация заявок по пользователю **/
            //    ]);
            $query->andFilterWhere([
                'status' => ['status' => Request::STATUS_DONE] /** Выполненная заявка **/
            ]);
        } elseif ($status === Request::STATUS_DUE) { /** Нераспределенные срочные заявка **/
            if(!(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR)))
                $query->andFilterWhere([
                    'work_whom' => ['work_whom' => Yii::$app->user->getId()] /** Фильтрация заявок по пользователю **/
                ]);
            $query->andFilterWhere([
                'status' => ['status' => Request::STATUS_DUE] /** Срочная заявка **/
            ]);

        }  elseif ($status === Request::STATUS_DUE_WORK) { /** Распределенные срочные заявка **/
            if (!(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR)))
                $query->andFilterWhere([
                    'work_whom' => ['work_whom' => Yii::$app->user->getId()]/** Фильтрация заявок по пользователю **/
                ]);
            $query->andFilterWhere([
                'status' => ['status' => Request::STATUS_DUE_WORK]/** Срочная заявка **/
            ]);
        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'                            => $this->id,
            'building_id'                   => $this->building_id,
            'user_id'                       => $this->user_id,
            'created_at'                    => $this->created_at,
            'deleted'                       => ['deleted' => null],
            'deleted_at'                    => $this->deleted_at,
            'done'                          => $this->done,
            //'done_at'                       => $this->done_at,
            'request.type'                  => $this->type,
            'invoice'                       => $this->invoice,
            'invoce_at'                     => $this->invoce_at,
            'type_of_work'                  => $this->type_of_work,
            'room'                          => $this->room,
            'work_whom'                     => $this->work_whom,
        ]);


        $query->andFilterWhere(['like', 'description', $this->description])
            //->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description_done', $this->description_done])
            ->andFilterWhere(['>=', 'created_at', $this->created_start ? strtotime($this->created_start . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->created_end ? strtotime($this->created_end . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'done_at', $this->done_start ? strtotime($this->done_start . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'done_at', $this->done_end ? strtotime($this->done_end . ' 23:59:59') : null]);
        return $dataProvider;
    }
}
