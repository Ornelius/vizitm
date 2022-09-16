<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vizitm\helpers\StreetHelper;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\Building */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'street_id')->dropDownList(StreetHelper::streetList()) ?>
    <?= $form->field($model, 'buildingnumber')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
