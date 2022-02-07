<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\Building */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_of_building')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_of_floors')->textInput() ?>

    <?= $form->field($model, 'zero_floor')->textInput() ?>

    <?= $form->field($model, 'number_of_section')->textInput() ?>

    <?= $form->field($model, 'number_of_aparnment')->textInput() ?>

    <?= $form->field($model, 'area_of_building')->textInput() ?>

    <?= $form->field($model, 'area_of_floors')->textInput() ?>

    <?= $form->field($model, 'number_of_lifts')->textInput() ?>

    <?= $form->field($model, 'number_of_trash_chute')->textInput() ?>

    <?= $form->field($model, 'PPA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office_flore')->textInput() ?>

    <?= $form->field($model, 'kotelnaya')->textInput() ?>

    <?= $form->field($model, 'boilernaya')->textInput() ?>

    <?= $form->field($model, 'pumps')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
