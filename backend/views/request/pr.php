<?php

use dynamikaweb\lightgallery\LightGallery;
use kartik\tabs\TabsX;
use vizitm\entities\request\Photo;
use vizitm\entities\request\Request;
use vizitm\entities\Users;
use vizitm\helpers\RequestHelper;
use vizitm\helpers\UserHelper;
use yii\bootstrap4\Tabs;
use yii\helpers\Html;
use yii\grid\GridView;
use vizitm\helpers\AddressHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\request\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $request_status */
if($request_status === 1){
    $this->title = 'Новые заявки';
    $hasNew             = true;
    $hasWork            = false;
    $hasDone            = false;
    $hasDeu             = false;
    $hasDeuWork         = false;
} elseif ($request_status === 2) {
    $this->title = 'Заявки в работе';
    $hasNew             = false;
    $hasWork            = false;
    $hasDone            = false;
    $hasDeu             = false;
    $hasDeuWork         = false;
    $position = Users::findUserByID(Yii::$app->user->getId())->position;
    if(($position === 3) || ($position === 6))
        $hasWork = true;
} elseif ($request_status === 3) {
    $this->title = 'Выполненные заявки';
    $hasNew             = false;
    $hasWork            = false;
    $hasDone            = true;
    $hasDeu             = false;
    $hasDeuWork         = false;
} elseif ($request_status === 4) {
    $this->title = 'Нерспределенные срочные заявки';
    $hasNew             = false;
    $hasWork            = false;
    $hasDone            = false;
    $hasDeu             = true;
    $hasDeuWork         = false;
} elseif ($request_status === 5) {
    $this->title = 'Распределенные срочные заявки';
    $hasNew             = false;
    $hasWork            = false;
    $hasDone            = false;
    $hasDeu             = false;
    $hasDeuWork         = false;
    $position = Users::findUserByID(Yii::$app->user->getId())->position;
    if(($position === 3) || ($position === 6))
        $hasDeuWork = true;
}

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="modal inmodal staff" id="staffForm" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md "></div>
</div>


<div class="request-index">

    <p>
        <?php
        if($request_status === 1)
            echo Html::a( $this->title, ['create'], ['class' => 'btn btn-success']);
        ?>


    </p>
    <?php
    Pjax::begin();
    $content1 = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'headerRowOptions' => ['style' => 'text-align: center; vertical-align: middle'],
        'rowOptions' => ['style' => 'text-align: center'],
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //['class' => 'yii\grid\ActionColumn', 'headerOptions' => ['width' => '60'], 'visible' => $hasAccess,],
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:60px;vertical-align: middle;'],
                'contentOptions' => ['style'=>'vertical-align: middle;'],
                'filter' => false

            ],

            [
                'attribute' => 'building_id',
                'headerOptions' => ['style' => 'width:160px; vertical-align: middle;'],
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
                'contentOptions' => ['style' => 'width: 50%; max-height:: 50px'],
                'headerOptions' => ['style' => 'width: 50%; vertical-align: middle;'],
                'value' => function (Request $request):string
                {
                    return getRequestItems($request);
                },
                'format' => 'raw',
            ],

            [
                'attribute' => 'created_at',
                'contentOptions' => ['style'=>'vertical-align: middle;'],
                'label' => 'Дата создания',
                'format' => 'datetime',
                'filter' => false,
                'headerOptions' => ['style' => 'width:80px;vertical-align: middle;'],
            ],
            [
                'attribute' => 'type',
                'contentOptions' => ['style'=>'vertical-align: middle;'],
                'headerOptions' => ['style' => 'width:120px; vertical-align: middle;'],
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
                'headerOptions' => ['style' => 'width:120px;vertical-align: middle;'],
                'filter' => RequestHelper::roomList(),
                'value' => function(Request $request)
                {
                    return RequestHelper::roomName($request->room);
                }

            ],
            [
                'attribute'         => 'work_whom',
                'contentOptions'    => ['style'=>'vertical-align: middle;'],
                'headerOptions'     => ['style' => 'width:120px;vertical-align: middle;'],
                'label'             => 'В работе у сотрудника',
                'format'            => 'raw',
                'filter'            => UserHelper::ListPositionUsers(),
                'value'             => function(Request $request)
                {
                    return Users::findUserByID($request->work_whom)->lastname;
                },
                'visible'           => $hasWork or $hasDeuWork,
            ],
            [
                'attribute' => 'done_at',
                'format' => 'datetime',
                'visible' => $hasDone,

            ],
            [
                'attribute' => 'description_done',
                'visible' => $hasDone,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:10px'],
                'contentOptions' => ['style'=>'vertical-align: middle;width:10px'],
                'template' => '{delete} {staff} {done}', //{view} {update}
                'visibleButtons'=>[
                    'delete'=> function(Request $request){ //Кнопка delete отображается у того кто создал заявку или у инженера
                        $user_id = Yii::$app->user->getId();
                        if(($request->user_id === $user_id) || (Users::findUserByID($user_id)->position === 3))
                            return true;
                        return false;
                    },
                    'done'=> function(Request $request){ //Кнопка done отображается у того кому назначена заявка
                        $user_id = Yii::$app->user->getId();
                        if(($request->status === Request::STATUS_WORK || $request->status === Request::STATUS_DUE_WORK) && $user_id === $request->work_whom)
                            return true;
                        return false;
                    },
                    'staff'=> function(Request $request){
                        $user_id = Yii::$app->user->getId();
                        if($request->status === Request::STATUS_NEW || (Users::findUserByID($user_id)->position === 3))
                            return true;
                        return false;
                    },
                    'update'=> function(Request $request){
                        if($request->status === Request::STATUS_NEW)
                            return true;
                        return false;
                    },
                ],
                'buttons' => [
                    'staff' => function($url, $modal) {     // render your custom button
                        return Html::a('<i class="fas fa-user-tie"></i>', Url::toRoute(['request/direct', 'id' => $modal->id]),
                            [
                                'title' => 'Назначить ответственного',
                                'data-toggle' => 'modal',
                                'class' => 'staffForm',
                                //'data-target' => '#staffForm',
                                'id' => 'staffFormButton'
                            ]
                        );
                    },
                    'done' => function($url, $modal) {     // render your custom button
                        return Html::a('<i class="fas fa-check-square"></i>', Url::toRoute(['request/request-done', 'id' => $modal->id]));
                    }
                ]
            ]
        ],
    ]);


    //echo $content1;
    Pjax::end();
    $items1 = [
        [
            'label' => 'Administrators',
            'url' => Url::toRoute(['/request/index']),
            'active' => $action == 'index',
            'content' => function(){
                echo $content1;
            }
        ],
        [
            'label' => 'Members Tracker',
            'url' => Url::to(['/request/work']),
            'active' => $action == 'work',
            'content' => $content1
        ],
        [
            'label' => 'Pages',
            'url' => Url::to(['/admin/pages']),
        ],
    ];

    echo Tabs::widget([
        'items'=>$items1,
        'encodeLabels'=>false
    ]);



    ?>
    <!-- POPUP MODAL CONTACT -->
    <div class="modal" id="addStaffFormModel" role="dialog">
        <div class="modal-dialog modal-md "></div>
    </div>


    <?php
    function getRequestItems(Request $request)
    {
        $i=0;
        $items[] = null;
        $hrefvideo = null;
        $hrefpdf = null;
        $due_date = null;
        if(!$request->photo){
            $items[0] = [
                'thumb' => '@web/uploads/noimage/noimage.png',
                'src'   => '@web/uploads/noimage/noimage.png',
                'imgOptions' =>  [
                    'width' => '100%',
                    'alt' => 'No Image',
                ],
            ];


        } else {
            foreach ($request->photo as $photo)
            {
                if ($i === 0 && $photo->type === Photo::PHOTO_OF_PROBLEM) {
                    $imageOption[$i]=
                        [
                            'width' => '100%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Выявленная проблема',
                        ];
                } else if ($photo->type === Photo::PHOTO_OF_PROBLEM) {
                    $imageOption[$i]=
                        [
                            'width' => '0%',
                            'high' => '0%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Выявленная проблема',
                            'style' => 'visibility: hidden; position: absolute; top: -9999px;'
                        ];
                } else if ($i === 0 && $photo->type === Photo::PHOTO_OF_PROBLEM_DONE) {
                    $imageOption[$i]=
                        [
                            'width' => '100%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Результат',
                        ];
                } else if ($photo->type === Photo::PHOTO_OF_PROBLEM_DONE) {
                    $imageOption[$i] =
                        [
                            'width' => '0%',
                            'high' => '0%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Результат',
                            'style' => 'visibility: hidden; position: absolute; top: -9999px;'
                        ];
                }
                if($photo->sort === Photo::TYPE_VIDEO){
                    $hrefvideo = Html::a(
                        '<i class="far fa-file-video" style="font-size:24px; margin: 1px; padding: 1px;"></i>',
                        $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                        ['target' => "_blank"]

                    );
                    $items[$i] = [
                        'thumb' => '@web/uploads/noimage/noimage.png',
                        'imgOptions' => [
                            'width' => '100%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Результат',
                        ],

                    ];
                } elseif ($photo->sort === Photo::TYPE_PDF) {
                    $hrefpdf = Html::a(
                        '<i class="far fa-file-pdf" style="font-size:24px; margin: 1px; padding: 1px;"></i>',
                        $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                        ['target' => "_blank"]

                    );
                    $items[$i] = [
                        'thumb' => '@web/uploads/noimage/noimage.png',
                        'imgOptions' => [
                            'width' => '100%',
                            'alt' => $request->building->address . ' ' . RequestHelper::roomName($request->room) . ' - ' . ' Результат',
                        ],

                    ];
                } else {
                    $items[$i] = [
                        'thumb' => $photo->getThumbFileUrl('path', 'thumb', '/uploads/noimage/noimage.png'),
                        'src' => $photo->getImageFileUrl('path','/uploads/noimage/noimage.png'),
                        'imgOptions' => $imageOption[$i],
                    ];
                }



                $i++;
            } //end foreach
        }

        if($request->status === Request::STATUS_DUE) {
            $due_date = '<i class="fas fa fa-calendar">  ' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
        } elseif ($request->status === Request::STATUS_DUE_WORK || $request->due_date !== null) {
            if($request->due_date > time()) {
                $due_date = '<i class="fas fa-exclamation-circle">  ' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
            } else {
                $due_date = '<i class="fas fa-exclamation-circle" style="color: crimson">  ' . Yii::$app->formatter->asDate($request->due_date) . '</i>';
            }
        }

        //$span = '<span class="badge bg-purple">' . $i . '</span>';
        //if($i > 0) {
        //$span = '<span class="badge bg-success">' . $i . '</span>';
        //}

        return
            '<div class="d-flex flex-row">'.
            //'<div style="display: -webkit-flex; display: flex; flex-direction: row;flex-wrap: nowrap;justify-content: flex-start">' .
            '<div class="d-flex align-items-center">' .
            //style="width:12%; margin: 4px; height: 22%; padding: 4px;
            //'<div data-video= "{"source": {"src":' . "\uploads\request\origion\78\29.mp4" . ', "type":"video/mp4"}, "attributes": {"preload": none, "controls": true}}", class="btn btn-app" style="width:12%; margin: 3px; height: 22%; padding: 3px;">' . $span .

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
                    //'data-video' => '{source:[{src:"/uploads/request/origion/78/29.mp4", type:"video/mp4"}], attributes:{playsinline:true, controls:true}}',
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
                    'videojsOptions' => [
                        'muted' => true,
                    ],
                    'zoomPluginStrings' => ['scale' => 2,'enableZoomAfter' => 300 ],

                    'data-iframe' => true,
                    //'html' => '<video class="lg-video-object lg-html5" controls="controls" preload="none" autostart="false" autoplay=""><source src="[(${video.link})]" type="video/mp4">Your browser does not support HTML5 video</video>',
                    //'autoplayVideoOnSlide' => true
                ],

            ]) . '</div>' .'<div class="d-flex align-items-center flex-column" style="width:5%;margin: 6px; padding: 6px;">' . $hrefvideo . $hrefpdf .

            '</div>
                            <div class="ml-auto d-flex align-items-center" style="margin: 3px; padding: 3px;">' . StringHelper::truncate($request->description, 200) .'</div>
                  </div><div class="d-flex flex-row"><div class="ml-auto d-flex align-items-center">'. $due_date .'</div></div>' ;

        //'</div></div>' .
        //'<div style="width: 100%; margin: 3px; padding: 3px;text-align: right;">' .

        //StringHelper::truncate($request->description, 200) .

        //'</div></div>
        //                         <div style="
        //                            width: 100%;
        //                            margin: 3px; /* Значение отступов */
        //                            //*border: 2px solid slategrey; /* Параметры границы */
        //                            padding: 3px; /* Поля вокруг текста */
        //                            height: 10px;
        //                            /*//border-radius: 10px;
        //                            align-content: start; */
        //                            text-align: right;

        //                            ">' .

        //$due_date

        // '</div>';

        //unset($due_date);
    }


    $this->registerJsFile(
        '@web/js/staffModal.js',
        ['depends' => [JqueryAsset::class]]);
    $this->registerJsFile(
        '@web/js/ajaxForm.js',
        ['depends' => [JqueryAsset::class]]);



    ?>

</div>

