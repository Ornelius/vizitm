<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\address\BuildingnumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Номера домов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buildingnumber-index">

    <p>
        <?= Html::a('Добавить номер дома', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'number',
            /*  [
                  'attribute' => 'created_by',
                  'value' => function (\vizitm\entities\street\Street $street) {
                      $user = \vizitm\entities\Users::findUserByID($street->created_by);
                      return $user->username . " " . "(" . $user->lastname . " " . $user->firstname . ")";
                  },
                  'format' => 'raw',
              ],
              [
                  'attribute'     => 'created_at',
                  'filter'        => DatePicker::widget([
                      'model'     =>  $searchModel,
                      'attribute'     =>  'date_from',
                      'attribute2'    =>  'date_to',
                      'type'          =>  DatePicker::TYPE_RANGE,
                      'separator'     =>  '-',
                      'pluginOptions' =>  [
                          'todayHighlight'    =>  true,
                          'autoclose'         =>  true,
                          'format'            =>  'yyyy-mm-dd',
                      ],

                  ]),
                  'format'    =>  'datetime',
              ],*/



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
