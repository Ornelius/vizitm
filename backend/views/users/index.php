<?php

use yii\helpers\Html;
use yii\grid\GridView;
use vizitm\helpers\UserHelper;
use kartik\daterange\DateRangePicker;
use vizitm\entities\Users;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="users-index">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i><?= Yii::$app->session->getFlash('success') ?></h5>
                 </div>
    <?php endif; ?>
    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php



    ?>

    <?=
            GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'headerRowOptions' => ['style' => 'text-align: center'],
            'rowOptions' => ['style' => 'text-align: center'],
            //'formatter' => ['class' => 'yii\i18n\Formatter', , 'locale' => 'ru-RU', 'dateFormat' => 'dd.MM.yyyy', ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'username',
                    'filterOptions' => ['style' => 'text-align: center'],
                    'value' => function (Users $user) {
                        return Html::a(Html::encode($user->username), Url::to(['profile/view', 'id' => $user->id]));
                    },
                    'format' => 'raw'
                ],
                'email:email',
                [
                    'attribute' => 'created_at',
                    'filterOptions' => ['style' => 'width: 220px; class=\'text-center\' '],
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute'=>'date_from',
                        'convertFormat'=>true,
                        'startAttribute'=>'date_from',
                        'endAttribute'=>'date_to',
                        'pluginOptions'=>[
                            //'timePicker'=>true,
                            //'timePickerIncrement'=>90,
                            'locale'=>[
                                'format'=>'Y-m-d','ru-Ru'
                            ]
                        ]

                    ]),
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'lastname',
                    'value' => function (Users $user) {
                        return $user->lastname . ' ' . $user->name;
                    },
                    'format' => 'raw',

                ],
                [
                    'attribute' => 'position',
                    'filter' => UserHelper::positionList(),
                    'value' => function (Users $user) {
                        return UserHelper::ListName($user->position, UserHelper::POSITION);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'contentOptions' => ['class' => 'text-center'],
                    'filter' => UserHelper::statusList(),
                    'value' => function (Users $user) {
                        return UserHelper::statusLabel($user->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                ],
            ],
        ]);
     ?>
</div>
