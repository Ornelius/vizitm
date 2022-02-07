<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\entities\Roles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
