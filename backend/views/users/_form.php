<?php

use vizitm\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['class'=>'form-control', 'type' => 'string']) ?>

    <?= $form->field($model, 'email')->textInput(['class'=>'form-control', 'type' => 'string']) ?>

    <?= $form->field($model, 'status')->dropDownList(UserHelper::statusList()) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
