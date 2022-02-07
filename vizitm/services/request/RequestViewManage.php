<?php


namespace vizitm\services\request;
use dynamikaweb\lightgallery\LightGallery;
use Exception;
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
                    'filter' => false,

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
                    'template' => '{delete} {staff} {done}', //{view} {update}
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
                            if($request->status === Request::STATUS_NEW)
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
                        }
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
        if(!$request->photo){
            $items[0] = [
                'thumb' => '@web/uploads/noimage/noimage.png',
                'src'   => '@web/uploads/noimage/noimage.png',
                'imgOptions' =>  [
                    'width' => '100%',
                    'title' => $title,
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
                    $style = '';
                    $high = '';
                }
                $imageOption[$i]= [
                    'tag'   => 'div',
                    'width' => $width,
                    'high'  =>  $high,
                    'alt'   => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . $text,
                    'style' => $style,
                    'title' => $title,
                    'data-video' => '{source:[{src:"/uploads/request/origion/9/2.mp4", type:"video/mp4"}], attributes:{playsinline:true, controls:true}}',
                ];
                if($photo->sort === Photo::TYPE_VIDEO){
                    $hrefvideo = Html::a(
                        '<i class="far fa-file-video" style="font-size:24px; margin: 1px; padding: 1px;"></i>',
                        $photo->getImageFileUrl('path','/uploads/noimage/video.png'),
                        ['target' => "_blank", 'data-pjax' => 0,]
                    );
                    $thumb = '@web/uploads/noimage/video.png';
                } elseif ($photo->sort === Photo::TYPE_PDF) {
                    $hrefpdf = Html::a(
                        '<i class="far fa-file-pdf" style="font-size:24px; margin: 1px; padding: 1px;"></i>',
                        $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                        ['target' => "_blank", 'data-pjax' => 0,]
                    );
                    $thumb = '@web/uploads/noimage/pdf.png';
                } else {
                    $thumb = $photo->getThumbFileUrl('path', 'thumb', '/uploads/noimage/noimage.png');
                }

                $items[$i] = [
                    'thumb' => $thumb,
                    'src' => $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                    'imgOptions' => $imageOption[$i],
                ];



                $i++;
            } //end foreach
        }

/*        if($request->status === Request::STATUS_DUE) {
            $due_date = '<i class="fas fa fa-calendar"></i>  <i>&nbsp' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
            if($request->due_date <= (time()+(4*60*60)))
                $due_date = '<i class="fas fa fa-calendar" style="color: crimson"></i>  <i>&nbsp' . Yii::$app->formatter->asDate($request->due_date)  . ' </i>';
        } elseif ($request->status === Request::STATUS_DUE_WORK) {
            $due_date = '<i class="fas fa-exclamation-circle" style="color: crimson"></i><i> &nbsp' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
            if($request->due_date >= (time()+(4*60*60)) && $request->done_at <= $request->due_date )
                $due_date = '<i class="fas fa-exclamation-circle" ></i> <i> &nbsp' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
        } elseif ($request->status === Request::STATUS_DUE_WORK) date("Y-m-d H:i:s",$request->due_date)*/

        if(!empty($request->due_date))
        {
            $style='"color: crimson"';
            if($request->due_date >= (time()+(4*60*60)) && $request->done_at <= $request->due_date)
                $style='';
            if(($request->status === Request::STATUS_DONE) && ($request->done_at <= $request->due_date))
                $style='';
            $due_date = '<i class="fas fa fa-calendar" style=' . $style . '></i><i>&nbsp' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
        }

        return
            '<div class="d-flex flex-row">'.
            //'<div style="display: -webkit-flex; display: flex; flex-direction: row;flex-wrap: nowrap;justify-content: flex-start">' .
            '<div class="d-flex align-items-center">' .
            //style="width:12%; margin: 4px; height: 22%; padding: 4px;
            //'<div data-video= "{source: {src:"/uploads/request/origion/9/2.mp4", "type":"video/mp4"}, "attributes": {"preload": none, "controls": true}}", class="btn btn-app" style="width:12%; margin: 3px; height: 22%; padding: 3px;">' . //$span .

            LightGallery::widget([
                'items' => $items,
                'options' => [
                    //'class' =>  ["d-flex align-items-center"],
                    //'tag' => 'video',
                    //'class' => 'item',
                    //'style' =>['width:12%; margin: 3px; height: 22%; padding: 3px;'],
                    //'data-src' => "/uploads/bill.pdf",
                    //'data-iframe'=>"true",
                    //'src' => '/uploads/request/origion/78/29.mp4',
                    //'data-src'="https://file-examples-com.github.io/uploads/2017/10/file-sample_150kB.pdf",
                    //'data-src' => '{source:[{src:"/uploads/request/origion/9/2.mp4", type:"video/mp4"}], attributes:{playsinline:true, controls:true}}',
                ],
                'plugins' => [
                    'lgZoom',
                    'lgVideo',
                    'lgComment',
                    // 'lgFullscreen' ,
                    'lgHash',
                    'lgPager',
                    'lgRotate',
                    //'lgShare',
                    'lgThumbnail',
                    //'lgMediumZoom'
                ],
                'pluginOptions' => [
                    'licenseKey' => '1B546F35-ACDD4F47-B8915F40-2620D382',
                    'download' => false,
                    'zoom' => true,
                    'share' => false,
                    'thumbnail' => true,
                    'allowMediaOverlap' => true,
                    'videojs' => true,
                    //'videojsOptions' => [
                    //    'muted' => true,
                    //],
                    'zoomPluginStrings' => ['scale' => 2,'enableZoomAfter' => 300 ],

                    'data-iframe' => true,
                    //'html' => '<video class="lg-video-object lg-html5" controls="controls" preload="none" autostart="false" autoplay=""><source src="[(${video.link})]" type="video/mp4">Your browser does not support HTML5 video</video>',
                    //'autoplayVideoOnSlide' => true
                ],

            ]) . '</div>' .'<div class="d-flex align-items-center flex-column" style="width:5%;margin: 6px; padding: 6px;">' . $hrefvideo . $hrefpdf .

            '</div>
                            <div class="ml-auto d-flex align-items-center" style="margin: 3px; padding: 3px;" >' . StringHelper::truncate($request->description, 250) .'</div>
                  </div><div class="d-flex flex-row"><div class="ml-auto d-flex align-items-center" style="font-size-adjust: inherit">'. $due_date .'</div></div>' ;

    }


}