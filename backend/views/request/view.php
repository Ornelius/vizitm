<?php

use vizitm\entities\request\Direct;
use vizitm\entities\Users;
use vizitm\helpers\AddressHelper;
use vizitm\helpers\RoomHelper;
use vizitm\services\request\LightingGallery;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\Request */

$this->title = 'Заявка № ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => [Yii::$app->request->get('viewName')]];
$this->params['breadcrumbs'][] =  Html::encode($this->title);
//YiiAsset::register($this);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">

                        </div>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Адрес</b> <a class="float-right">
                                    <?= AddressHelper::addressName($model->building_id) ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Тип помещения</b> <a class="float-right">
                                    <?= RoomHelper::roomName($model->room) ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Тип заявки</b> <a class="float-right">
                                    <?php
                                        $val = 'Обычная';
                                        if($model->due_date)
                                            $val = Yii::$app->formatter->asDate($model->due_date);
                                        echo $val;
                                    ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Timeline</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="timeline">

                                <div class="timeline timeline-inverse">

                                    <div class="time-label">
                                        <span class="bg-danger">
                                            <?php Yii::$app->formatter->locale = 'ru-RU';
                                             echo Yii::$app->formatter->asDate($model->created_at)

                                            ?>
                                        </span>
                                    </div>


                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i>
                                            <?= Yii::$app->formatter->asTime($model->created_at, 'short') ?>
                                            </span>
                                            <h3 class="timeline-header"><a href="#">
                                                <?= Users::getFullNameNotActive($model->user_id); ?>
                                                </a> сформировал заявку</h3>
                                            <div class="timeline-body">
                                                <?= $model->description ?>
                                            </div>
                                            <div class="timeline-footer">
                                                <?php
                                                    echo LightingGallery::getRequestItems($model, true);
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $direct = Direct::findAll(['request_id' => $model->id]);
                                        if(!$direct) {
                                            echo '<div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                </div>';
                                        } else {
                                            foreach ($direct as $dr){
                                                echo '<div class="time-label">
                                                    <span class="bg-info">' .
                                                    Yii::$app->formatter->asDate($dr->direct_datetime) .
                                                    '</span>
                                                  </div> 
                                                  <div>
                                                    <i class="fas fa-user bg-info"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> ' .
                                                    Yii::$app->formatter->asTime($dr->direct_datetime, 'short') .
                                                    '</span>
                                                            <h3 class="timeline-header border-0"><a href="#">' . Users::getFullName($dr->direct_from) .'</a> направил заявку ' . Users::getFullName($dr->direct_to) .
                                                    '</h3>
                                                        </div>
                                                    </div>              
                                                  ';
                                            }
                                            if(!$model->done){
                                                echo '<div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                </div>';
                                            } else {
                                                echo '

                                                    <div class="time-label">
                                                        <span class="bg-green">' .
                                                            Yii::$app->formatter->asDate($model->done_at) .
                                                        '</span>
                                                    </div> 
                                        
                                        
                                        <div>
                                        <i class="fas fa-envelope bg-green"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> ' . Yii::$app->formatter->asTime($model->done_at, 'short') . '</span>
                                            <h3 class="timeline-header"><a href="#"> ' . Users::getFullName($model->work_whom) . '</a> выполнил заявку</h3>
                                            <div class="timeline-body">' . $model->description_done . '</div>' .
                                               '<div class="timeline-footer">' .
                                                        LightingGallery::getRequestItems($model, true) .
                                                '</div>' .
                                        '</div>
                                    </div>
                                    <div>
                                                    <i class="far fa-stop bg-gray"></i>
                                                </div>
                                    ';
                                            }


                                        }
                                    ?>






                                </div>
                            </div>



                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
