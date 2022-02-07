<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\street\BuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buildings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-index">

    <p>
        <?= Html::a('Create Building', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'year_of_building',
            'number_of_floors',
            'zero_floor',
            //'number_of_section',
            //'number_of_aparnment',
            //'area_of_building',
            //'area_of_floors',
            //'number_of_lifts',
            //'number_of_trash_chute',
            //'PPA',
            //'office_flore',
            //'kotelnaya',
            //'boilernaya',
            //'pumps',
            //'street_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
