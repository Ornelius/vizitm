<?php


namespace vizitm\services\request;
use Exception;
use kartik\daterange\DateRangePicker;
use vizitm\entities\Users;
use vizitm\entities\slaves\Slaves;
use vizitm\helpers\AddressHelper;
use vizitm\helpers\RequestHelper;
use vizitm\helpers\UserHelper;
use Yii;
use yii\grid\GridView;
use vizitm\entities\request\Request;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class RequestViewManage
{

    public ?string  $content = null;
    public ?int     $userID;
    public ?int     $userPosition;
    public ?bool    $statusOfButton;


    public function __construct()
    {
        $this->userID = Yii::$app->user->getId();
        $this->userPosition = Users::findUserByIDNotActive($this->userID)->position;
        $this->statusOfButton = $this->getPosition();
    }
    public function getPosition(): bool
    {
        if($this->userPosition !== Users::POSITION_DEGURNI_OPERATOR)
            return true;

        return true;

    }

    /**
     * @throws Exception
     */
    public function setContent(
        $dataProvider,
        $searchModel
    )
    {
        $viewName = Yii::$app->controller->action->id;
        $hasWork = false;
        $hasDeuWork = false;
        $hasDone = false;
        if($viewName === 'work'){
            $hasWork = true;
        } elseif ($viewName === 'duework'){
            $hasDeuWork = true;
        } elseif ($viewName === 'done') {
            $hasDone = true;
        }
        $label = 'В работе у сотрудника';
        if ($viewName === 'done')
            $label = 'Выполнил сотрудник';

        $this->content = GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => "Показано записей: <b>{begin} - {end} из {totalCount}</b>",
            'headerRowOptions' => ['style' => 'text-align: center; vertical-align: middle'],
            'rowOptions' => ['style' => 'text-align: center'],
            'options' => [ 'style' => 'table-layout:fixed;' ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width:3vh;vertical-align: middle;'],
                    'contentOptions' => ['style'=>'vertical-align: middle;'],
                    'filter' => false

                ],

                [
                    'attribute' => 'building_id',
                    'headerOptions' => ['style' => 'width:10vh; vertical-align: middle;'],
                    'contentOptions' => ['style'=>'vertical-align: middle;'],
                    'filter' => RequestHelper::addressList(),
                    'value' => function(Request $request  )
                    {
                        $address = AddressHelper::addressName($request->building_id);
                        return Html::a(Html::encode($address), 'https://yandex.ru/maps/?text=Самара,' .
                            Html::encode($address), ['target' => '_blank']

                        );
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'description',
                    'contentOptions' => ['style' => 'max-height:: 50px'],
                    'headerOptions' => ['style' => 'width: 55vh; vertical-align: middle;'],
                    'value' => function (Request $request): string
                    {
                        $viewName = Yii::$app->controller->action->id;
                        return LightingGallery::getRequestItems($request, $viewName);
                    },
                    'format' => 'raw',
                ],

                [
                    'attribute' => 'created_at',
                    'contentOptions'    => ['style'=>'vertical-align: middle;'],
                    'headerOptions'     => ['style' => 'width:10vh;vertical-align: middle;'],
                    'label' => 'Дата создания',
                    'format' => 'datetime',
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute'=>'created_range',
                        'convertFormat'=>true,
                        'startAttribute'=>'created_start',
                        'endAttribute'=>'created_end',
                        'pluginOptions'=>[
                            'locale'=>[
                                'format'=>'Y-m-d',
                                'ru-Ru',
                                //'separator'=>'-',
                            ],
                            'opens'=>'left'
                        ]
                    ]) ,

                ],
                [
                    'attribute' => 'type',
                    'contentOptions' => ['style'=>'vertical-align: middle;'],
                    'headerOptions' => ['style' => 'width:5vh; vertical-align: middle;'],
                    'format' => 'raw',
                    'filter' => RequestHelper::typeRequestList(),
                    'value' => function(Request $request)
                    {
                        return RequestHelper::typeRequestMnemonicName($request->type);
                    }
                ],
                [
                    'attribute' => 'room',
                    'contentOptions' => ['style'=>'vertical-align: middle;'],
                    'headerOptions' => ['style' => 'width:10vh;vertical-align: middle;'],
                    'filter' => RequestHelper::roomList(),
                    'value' => function(Request $request)
                    {
                        return RequestHelper::roomName($request->room);
                    }

                ],
                [
                    'attribute'         => 'work_whom',
                    'contentOptions'    => ['style' =>'vertical-align: middle;'],
                    'headerOptions'     => ['style' => 'width:10vh;vertical-align: middle;'],
                    'label'             => $label,
                    'format'            => 'raw',
                    'filter'            => UserHelper::ListPositionUsersNotActive(),
                    'value'             => function(Request $request)
                    {
                        if(!$user = Users::findUserByIDNotActive($request->work_whom))
                            return "Нет пользователя!";
                        return $user->lastname;
                    },
                    'visible'           => $hasWork or $hasDeuWork or $hasDone,
                ],
                [
                    'attribute' => 'done_at',
                    'contentOptions'    => ['style'=>'vertical-align: middle;'],
                    'headerOptions'     => ['style' => 'width:10vh;vertical-align: middle;'],
                    'label'             => 'Дата исполнения',
                    'format' => 'datetime',
                    'visible' => $hasDone,
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        //'name'=>'date_range_2',
                        'attribute'=>'done_range',
                        'convertFormat'=>true,
                        'startAttribute'=>'done_start',
                        'endAttribute'=>'done_end',
                        'pluginOptions'=>[
                            'locale'=>[
                                'format'=>'Y-m-d',
                                'ru-Ru',
                                //'separator'=>'-',
                            ],
                            'opens'=>'left'
                        ]
                    ]) ,

                ],
                [
                    'attribute'         => 'description_done',
                    'contentOptions'    => ['style' =>'vertical-align: middle;'],
                    'headerOptions'     => ['style' => 'width:20vh;vertical-align: middle;'],
                    'label'             => 'Описание результата',
                    'value'             => function(Request $request)
                    {
                        return StringHelper::truncate($request->description_done, 50);
                    },
                    'visible' => $hasDone,
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions'     => ['style' => 'width:1vh; vertical-align: middle;'],
                    'contentOptions'    => ['style'=>'vertical-align: middle;'],
                    'template' => '{delete} {staff} {done} {update} {view}' , //{update} {view}
                    'visible' => $this->statusOfButton,
                    'visibleButtons'=> [
                        'delete'=> function(Request $request): bool { //Кнопка delete отображается у того кто создал заявку или у Гланогоинженера и убрана в готовых заявках
                            if((Users::isSelf($request->user_id) || Users::isPositionGalvaniEngineer($this->userID)) && !$request->isDone())
                                return true;
                            return false;
                        },
                        'done'=> function(Request $request): bool { //Кнопка done отображается у того кому назначена заявка
                            if(($request->isWork() || $request->isDueWork()) && Users::isSelf($request->work_whom))
                                return true;
                            return false;
                        },
                        'staff'=> function(Request $request): bool {
                            $boll = false;
                            if( //
                                ($request->isNew() || Users::isPositionGalvaniEngineer($this->userID)) &&
                                !$request->isDone() && $request->emptyDueDate() && !Users::isPositionDegurniOperator($this->userID)
                            )
                                $boll = true;
                            if(
                                $request->isWork() && !$request->isDone() && $request->emptyDueDate() && !Users::isPositionDegurniOperator($this->userID)
                                && (Users::isPositionGalvaniEngineer($this->userID) || Slaves::haveSlaves($this->userID))
                            )
                                $boll = true;
                            if( Users::isPositionGalvaniEngineer($this->userID) && !$request->isDone() && !$request->emptyDueDate())
                            {
                                $boll = false;
                                if ($request->due_date >= (time() + (4 * 60 * 60)))
                                    $boll = true;
                            }
                            return $boll;
                        },
                        'update'=> function(Request $request): bool {
                            if(($request->isNew() || $request->isDue()) && Users::isSelf($request->user_id))
                                return true;
                            return false;
                        },
                    ],
                    'buttons' => [
                        'delete' => function($url, $model, $key) use ($viewName) {

                            return Html::a('<i class="fas fa-trash-alt"></i>',
                                [Url::toRoute(['request/delete', 'id' => $key, 'viewName' => $viewName])],
                                [
                                'class' => '',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить Заявку№ '. $key . '?' ,
                                    'method' => 'post',
                                ],
                            ]);
                        },
                        'staff' => function($url, $model, $key) use ($viewName) {     // render your custom button
                            return Html::a('<i class="fas fa-user-tie"></i>', Url::toRoute(['request/direct', 'id' => $key, 'viewName' => $viewName]),
                                [
                                    'title' => 'Назначить ответственного',
                                    'data-toggle' => 'modal',
                                    'class' => 'staffForm',
                                    //'data-target' => '#staffForm',
                                    //'id' => 'staffFormButton'
                                ]
                            );
                        },
                        'done' => function($url, $model, $key) use ($viewName) {     // render your custom button
                            return Html::a('<i class="fas fa-check-square"></i>', Url::toRoute(['request/request-done', 'id' => $key, 'viewName' => $viewName]));
                        },
                        'update' => function($url, $model, $key) use ($viewName) {

                            return Html::a('<i class="fas fa-pencil-alt"></i>',
                                [Url::toRoute(['request/update', 'id' => $key, 'viewName' => $viewName])],
                                );
                        },
                        'view' => function($url, $model, $key) use ($viewName) {

                            return Html::a('<i class="fas fa-eye"></i>',
                                [Url::toRoute(['request/view', 'id' => $key, 'viewName' => $viewName])],
                            );
                        },
                    ]
                ]
            ],
        ]);}


    public function getContent(): ?string
    {
        return $this->content;
    }

}