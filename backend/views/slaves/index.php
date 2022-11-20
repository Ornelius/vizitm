<?php

use vizitm\entities\slaves\Slaves;
use vizitm\entities\Users;
use vizitm\helpers\PositionHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use vizitm\entities\address\Street;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\address\StreetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подчиненные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slaves-index">
    <?php if (Yii::$app->session->hasFlash('error')):  ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation-circle" aria-hidden="true"> <?= Yii::$app->session->getFlash('error') ?></i>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" id="successMessage">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i><?= Yii::$app->session->getFlash('success') ?></h5>
        </div>
    <?php endif; ?>
    <p>
        <?= Html::a('Добавить подчиненного', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions'     => ['style' => 'width:1vh; vertical-align: middle;'],
                'contentOptions'    => ['style'=>'vertical-align: middle;'],
            ],

            [
                'attribute' => 'slave_id',
                'contentOptions'    => ['style'=>'vertical-align: middle;'],
                'headerOptions'     => ['style' => 'vertical-align: middle;'],
                'value' => function (Slaves $slave) {
                    $user = Users::findUserByID($slave->slave_id);
                    return $user->lastname . " " . $user->name;
                },
                'format' => 'raw',
            ],
            [
                'label'             => 'Должность',
                'contentOptions'    => ['style'=>'vertical-align: middle;'],
                'headerOptions'     => ['style' => 'vertical-align: middle;'],
                'value' => function (Slaves $slave) {
                    $user = Users::findUserByID($slave->slave_id);
                    return PositionHelper::positionName($user->position);
                },
                'format' => 'raw',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions'     => ['style' => 'width:1vh; vertical-align: middle;'],
                'contentOptions'    => ['style'=>'vertical-align: middle;'],
                'template' => '{delete}' , //{update} {view}
                //'visibleButtons'=> ['delete']],
            ],
        ]
    ]); ?>


</div>
