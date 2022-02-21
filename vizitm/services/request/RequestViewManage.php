<?php


namespace vizitm\services\request;
use dynamikaweb\lightgallery\LightGallery;
use Exception;
use kartik\daterange\DateRangePicker;
use vizitm\entities\request\Photo;
use vizitm\entities\Users;
use vizitm\helpers\AddressHelper;
use vizitm\helpers\RequestHelper;
use vizitm\helpers\UserHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\grid\GridView;
use vizitm\entities\request\Request;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class RequestViewManage
{

    public ?string  $content;
    public ?int     $userID;
    public ?int     $userPosition;
    public ?bool    $statusOfButton;


    public function __construct()
    {
        $user_id = Yii::$app->user->getId();
        $this->userID       = $user_id;
        $this->userPosition = Users::findUserByID($user_id)->position;
        $this->statusOfButton = $this->getPosition();
    }
    public function getPosition(): bool
    {
        if($this->userPosition !== Users::POSITION_DEGURNI_OPERATOR)
            return true;
        return false;

    }

    /**
     * @throws Exception
     */
    public function setContent(
        $dataProvider,
        $searchModel,
        //$hasNew             = false,
        $hasWork            = false,
        $hasDone            = false,
        //$hasDeu             = false,
        $hasDeuWork         = false,
        $viewName            = null
    )
    {
        $label = 'В работе у сотрудника';
        if ($hasDone === true)
            $label = 'Выполнил сотрудник';

        $this->content = GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => "Показано записей: <b>{count}</b>",
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
                    'value' => function (Request $request):string
                    {
                        return $this->getRequestItems($request);
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
                    'filter'            => UserHelper::ListPositionUsers(),
                    'value'             => function(Request $request)
                    {
                        return Users::findUserByID($request->work_whom)->lastname;
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
                    'visible' => $hasDone,
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions'     => ['style' => 'width:1vh; vertical-align: middle;'],
                    'contentOptions'    => ['style'=>'vertical-align: middle;'],
                    'template' => '{delete} {staff} {done} {update}' , //{update} {view}
                    'visible' => $this->statusOfButton,
                    'visibleButtons'=> [
                        'delete'=> function(Request $request): bool { //Кнопка delete отображается у того кто создал заявку или у инженера
                            if(($request->user_id === $this->userID) || ($this->userPosition === Users::POSITION_GL_INGENER))
                                return true;
                            return false;
                        },
                        'done'=> function(Request $request): bool { //Кнопка done отображается у того кому назначена заявка
                            if(($request->status === Request::STATUS_WORK || $request->status === Request::STATUS_DUE_WORK) && $this->userID === $request->work_whom)
                                return true;
                            return false;
                        },
                        'staff'=> function(Request $request): bool {
                            $boll = false;
                            if((($request->status === Request::STATUS_NEW) || ($this->userPosition === Users::POSITION_GL_INGENER)) && ($request->status !== Request::STATUS_DONE) && empty($request->due_date))
                                $boll = true;
                            if((($request->status === Request::STATUS_NEW) || ($this->userPosition === Users::POSITION_GL_INGENER)) && ($request->status !== Request::STATUS_DONE) && !empty($request->due_date))
                            {
                                $boll = false;
                                if ($request->due_date >= (time() + (4 * 60 * 60)))
                                    $boll = true;
                            }
                            //$boll = true;
                            return $boll;
                        },
                        'update'=> function(Request $request): bool {
                            if((($request->status === Request::STATUS_NEW || $request->status === Request::STATUS_DUE) && ($request->user_id === $this->userID))

                            )
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
                                    'id' => 'staffFormButton'
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
                    ]
                ]
            ],
        ]);}


    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    private function getRequestItems(Request $request): string
    {

        $i=0;
        $items[] = null;
        $hrefvideo = null;
        $hrefpdf = null;
        $due_date = null;
        $title = 'Заявку сформировал: '. Users::getFullName($request->user_id);
        $itemsOptions[] = null;

        if(!$request->photo){
            $items[0] = [
                'thumb' => '@web/uploads/noimage/noimage.png',
                'src'   => '@web/uploads/noimage/noimage.png',
                'imgOptions' =>  [
                    'width' => '90px',
                    'title' => $title,
                    'style' => 'border-radius: 10px; ',//'border-radius: 10px; border: 0.1px #ccc solid; box-shadow: 0 0 4px #444;',
                    'alt' => 'No Image',
                ],
            ];

        } else {

            foreach ($request->photo as $photo)
            {
                $text = 'Выявленная проблема';
                $width = '0%';
                $high = '0%';
                $style = 'visibility: hidden; position: absolute; top: -9999px;';
                if($photo->type === Photo::PHOTO_OF_PROBLEM) {
                    $text = 'Выявленная проблема';
                } elseif ($photo->type === Photo::PHOTO_OF_PROBLEM_DONE) {
                    $text = 'Результат';
                }


                if ($i === 0) {
                    $width = '90px';
                    $style = 'border-radius: 10px;';//'border-radius: 10px; border: 0.1px #ccc solid; box-shadow: 0 0 3px #444;';
                    $high = '';
                }
                $itemsOptions[$i] = ['tag' => null];
                $imageOption[$i]= [
                    ///'tag'   => 'div',
                    'width' => $width,
                    'high'  =>  $high,
                    'alt'   => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . $text,
                    'style' => $style,
                    'title' => $title,
                ];

                if($photo->sort === Photo::TYPE_VIDEO){
                    $hrefvideo = '<i class="far fa-file-video" style="font-size:18px; margin: 1px; padding: 1px;"></i>';
                    $thumb = '@web/uploads/noimage/video.png';
                    $itemsOptions[$i] = ['tag' => 'div', 'class'=>'item', 'data-video' => '{"source":[{"src":"'. $photo->getImageFileUrl('path','/uploads/noimage/video.png') . '", "type":"video/mp4"}], "attributes":{"playsinline":true, "controls":true}}',];
                } elseif ($photo->sort === Photo::TYPE_PDF) {
                    $hrefpdf = '<i class="far fa-file-pdf" style="font-size:18px; margin: 1px; padding: 1px;"></i>';
                    $thumb = '@web/uploads/noimage/pdf.png';
                    $itemsOptions[$i] = ['tag' => 'div', 'src' => $photo->getImageFileUrl('path',$thumb), 'data-iframe' => 'true', 'class'=>'item'];
                } else {
                    $thumb = $photo->getThumbFileUrl('path', 'thumb', '/uploads/noimage/noimage.png');
                    $itemsOptions[$i] = ['tag' => null];
                }

                $items[$i] = [
                    'thumb' => $thumb,
                    'src' => $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                    'imgOptions' => $imageOption[$i],
                ];



                $i++;
            } //end foreach
        }


        if(!empty($request->due_date))
        {
            $style='"color: crimson; border-radius: 10px;"';
            if($request->due_date >= (time()+(4*60*60)) && $request->done_at <= $request->due_date)
                $style='';
            if(($request->status === Request::STATUS_DONE) && ($request->done_at <= $request->due_date))
                $style='';
            $due_date = '<i class="fas fa fa-calendar" style=' . $style . '></i><i>&nbsp' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
        }
        //$add = array(['tag' => null], ['tag' => null, 'data-video' => '234234234'], ['tag' => 'div', 'data-video' => '{"source": [{"src":"/uploads/request/origion/5/3.mp4", "type":"video/mp4"}], "attributes": {"preload": false, "playsinline": true, "controls": true}}']);
        return
            '<div class="d-flex flex-row">'.
            //'<div style="display: -webkit-flex; display: flex; flex-direction: row;flex-wrap: nowrap;justify-content: flex-start">' .
            '<div class="d-flex align-items-center">' .
            //style="width:12%; margin: 4px; height: 22%; padding: 4px;
            //'<div data-src= "{source: {src:"/uploads/request/origion/5/3.mp4", "type":"video/mp4"}, "attributes": {"preload": none, "controls": true}}", class="btn btn-app" style="width:12%; margin: 3px; height: 22%; padding: 3px;">' . //$span .

            LightGallery::widget([
                'items' => $items,
                'itemsOptions' => $itemsOptions,
                'options' => [
                    'mode' => 'lg-zoom-out'
                    //'class' =>  ["d-flex align-items-center"],
                ],
                'plugins' => [
                    'lgZoom',
                    'lgVideo',
                    //'lgComment',
                    //'lgFullscreen' ,
                    'lgHash',
                    'lgPager',
                    'lgRotate',
                    // 'lgShare',
                    'lgThumbnail',
                    // 'lgMediumZoom'
                ],
                'pluginOptions' => [
                    'licenseKey' => '1B546F35-ACDD4F47-B8915F40-2620D382',
                      'download' => false,
                    'zoom' => true,
                      'share' => false,
                      'thumbnail' => true,
                      //'allowMediaOverlap' => true,
                    'videjs' => true,
                    'videojsOptions' => [
                        'muted' => false,
                        //'data-src' => '{"source": [{"src":"/uploads/request/origion/5/3.mp4", "type":"video/mp4"}], "attributes": {"preload": false, "playsinline": true, "controls": true}}'
                    ],
                    //'zoomPluginStrings' => ['scale' => 2,'enableZoomAfter' => 300 ],

                    //'data-iframe' => true,
                    //'data-video'='{"source": [{"src":"/videos/video1.mp4", "type":"video/mp4"}], "tracks": [{"src": "{/videos/title.txt", "kind":"captions", "srclang": "en", "label": "English", "default": "true"}], "attributes": {"preload": false, "playsinline": true, "controls": true}}'
                    //'html' => '<video class="lg-video-object lg-html5" controls="controls" preload="none" autostart="false" autoplay=""><source data-video="[(/uploads/request/origion/5/3.mp4)]" type="video/mp4">Your browser does not support HTML5 video</video>',
                    //'autoplayVideoOnSlide' => true
                ],

            ]) . '</div>' .'<div class="d-flex align-items-center flex-column" style="width:5%;margin: 6px; padding: 6px;">' . $hrefvideo . '<p>'.$hrefpdf.'</p>' .

            '</div>
                            <div class="ml-auto d-flex align-items-center" style="margin: 3px; padding: 3px;" >' . StringHelper::truncate($request->description, 252) .'</div>
                  </div><div class="d-flex flex-row"><div class="ml-auto d-flex align-items-center" style="font-size-adjust: inherit">'. $due_date .'</div></div>' ;

    }


}