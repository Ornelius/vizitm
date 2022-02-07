<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\SearchRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'building_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'done') ?>

    <?php // echo $form->field($model, 'done_at') ?>

    <?php // echo $form->field($model, 'invoice') ?>

    <?php // echo $form->field($model, 'invoce_at') ?>

    <?php // echo $form->field($model, 'type_of_work') ?>

    <?php // echo $form->field($model, 'description_done') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
