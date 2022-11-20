<?php

use yii\grid\GridView;
use vizitm\helpers\StreetHelper;

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\building\BuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объекты недвижимсоти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Показано записей: <b>{begin} - {end} из {totalCount}</b>",
        'headerRowOptions' => ['style' => 'text-align: center; vertical-align: middle'],
        'rowOptions' => ['style' => 'text-align: center'],
        'options' => [ 'style' => 'table-layout:fixed;' ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label'     => 'Адрес',
                //'headerOptions' => ['width' => '80'],
                'filter' => StreetHelper::streetList() ,
                'value' => function ($dataProvider) {
                    return 'ул. '. $dataProvider['address'] ;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'newRequest',
                'label'     => 'Новые заявки',
                //'headerOptions' => ['width' => '80'],
                //'filter' => StreetHelper::streetList() ,
                'value' => function ($dataProvider) {
                    return $dataProvider['newRequest'] ;
                },
                'format' => 'raw',
            ],

            [
                'attribute' => 'workRequest',
                'label'     => 'Заявки в работе',
                //'headerOptions' => ['width' => '80'],
                //'filter' => StreetHelper::streetList() ,
                'value' => function ($dataProvider) {
                    return $dataProvider['workRequest'] ;
                },
                'format' => 'raw',
            ],

            [
                //'attribute' => 'street_id',
                'label'     => 'Общее количество заявок',
                //'filter' => StreetHelper::streetList() ,
                //'headerOptions' => ['width' => '80'],
                'value' => function ($dataProvider) {
                    $color = 'green';
                    $percent = $dataProvider['doneRequest']/$dataProvider['totalRequest'];
                    if($percent <= 0.21)
                        $color = 'red';
                    if($percent > 0.21 and $percent <= 0.19)
                        $color = 'blue';
                    return $dataProvider['totalRequest'] .
                        '<span style="color: ' . $color . '"> (' . Yii::$app->formatter->asPercent($percent) . ')</span>' ;
                },
                'format' => 'raw',
            ],

            [
                //'attribute' => 'street_id',
                'label'     => 'ХВС',
                //'filter' => StreetHelper::streetList() ,
                'value' => function () {
                    return 3 . ' м <sup>3</sup>' ;
                },
                'format' => 'raw',
            ],

            [
                //'attribute' => 'street_id',
                'label'     => 'ГАЗ',
                //'filter' => StreetHelper::streetList() ,
                'value' => function () {
                    return 3 . ' м <sup>3</sup>' ;
                },
                'format' => 'raw',
            ],

            [
                //'attribute' => 'street_id',
                'label'     => 'Электроэнергия',
                //'filter' => StreetHelper::streetList() ,
                'value' => function () {
                    return 3 . ' кВат*ч' ;
                },
                'format' => 'raw',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '' , //{update} {view}

            ],
        ],
    ]); ?>


</div>
