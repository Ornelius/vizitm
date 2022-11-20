<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\Building */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="building-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'number',
            'year_of_building',
            'number_of_floors',
            'zero_floor',
            'number_of_section',
            'number_of_aparnment',
            'area_of_building',
            'area_of_floors',
            'number_of_lifts',
            'number_of_trash_chute',
            'PPA',
            'office_flore',
            'kotelnaya',
            'boilernaya',
            'pumps',
            'street_id',
        ],
    ]) ?>

</div>
