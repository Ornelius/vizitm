<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\BuildingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'year_of_building') ?>

    <?= $form->field($model, 'number_of_floors') ?>

    <?= $form->field($model, 'zero_floor') ?>

    <?php // echo $form->field($model, 'number_of_section') ?>

    <?php // echo $form->field($model, 'number_of_aparnment') ?>

    <?php // echo $form->field($model, 'area_of_building') ?>

    <?php // echo $form->field($model, 'area_of_floors') ?>

    <?php // echo $form->field($model, 'number_of_lifts') ?>

    <?php // echo $form->field($model, 'number_of_trash_chute') ?>

    <?php // echo $form->field($model, 'PPA') ?>

    <?php // echo $form->field($model, 'office_flore') ?>

    <?php // echo $form->field($model, 'kotelnaya') ?>

    <?php // echo $form->field($model, 'boilernaya') ?>

    <?php // echo $form->field($model, 'pumps') ?>

    <?php // echo $form->field($model, 'street_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
