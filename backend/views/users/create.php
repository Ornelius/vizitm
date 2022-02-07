<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\forms\manage\User\UserCreateForm */

$this->title = 'Создание пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">
    <?php if (Yii::$app->session->hasFlash('error')):  ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation-circle" aria-hidden="true"> <?= Yii::$app->session->getFlash('error') ?></i>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
