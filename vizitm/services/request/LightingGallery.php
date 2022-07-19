<?php


namespace vizitm\services\request;


use dynamikaweb\lightgallery\LightGallery;
use vizitm\entities\request\Photo;
use vizitm\entities\request\Request;
use vizitm\entities\Users;
use vizitm\helpers\RequestHelper;
use Yii;
use yii\helpers\StringHelper;

class LightingGallery
{
    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public static function getRequestItems(Request $request, bool $view = false): string
    {

        $i=0;
        $items[] = null;
        $hrefvideo = null;
        $hrefpdf = null;
        $due_date = null;
        $description = null;
        $title = 'Заявку сформировал: '. Users::getFullNameNotActive($request->user_id);
        $itemsOptions[] = null;
        if($view == false)
            $description = $request->description;


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
                if ($view == false) {
                    $width = '0%';
                    $high = '0%';
                    $style = 'visibility: hidden; position: absolute; top: -9999px;';
                }
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
                    if ($view == false)
                        $hrefvideo = '<i class="far fa-file-video" style="font-size:18px; margin: 1px; padding: 1px;"></i>';
                    $thumb = '@web/uploads/noimage/video.png';
                    $itemsOptions[$i] = ['tag' => 'div', 'class'=>'item', 'data-video' => '{"source":[{"src":"'. $photo->getImageFileUrl('path','/uploads/noimage/video.png') . '", "type":"video/mp4"}], "attributes":{"playsinline":true, "controls":true}}',];
                } elseif ($photo->sort === Photo::TYPE_PDF) {
                    if ($view == false)
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

            LightingGalleryEXP::widget([
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

            ]) . '</div>' .
            '<div class=" timeline-item d-flex align-items-center flex-column" style="width:5%;margin: 6px; padding: 6px;">' . $hrefvideo . '<p>'.$hrefpdf.'</p>' .

            '</div>
                            <div class="ml-auto d-flex align-items-center" style="margin: 3px; padding: 3px;" >' . StringHelper::truncate($description, 120) .'</div>
                  </div>
                    <div class="d-flex flex-row"><div class="timeline-footer ml-auto d-flex align-items-center" style="font-size-adjust: inherit">'. $due_date .'</div>
                  </div>' ;

    }

}