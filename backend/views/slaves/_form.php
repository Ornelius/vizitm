<?php

use vizitm\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\street\Street */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="street-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'master_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false); ?>
    <?= $form->field($model, 'slave_id')->dropDownList(UserHelper::ListAllUsersExceptSome(Yii::$app->user->identity->id), ['prompt' => 'Выберите подчиненного']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
