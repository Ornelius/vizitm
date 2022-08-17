<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\Street */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="street-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
