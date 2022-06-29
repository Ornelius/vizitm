<?php

use vizitm\forms\LoginForm;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $form ActiveForm */
/* @var $model LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<?php if (Yii::$app->session->hasFlash('error_user')): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-exclamation-circle" aria-hidden="true"> <?= Yii::$app->session->getFlash('error_user') ?></i>
    </div>
<?php endif; ?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Админка </b>ООО "Визит-М"</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Заполните для начала сессии</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="d-flex flex-row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col"></div>
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>
        <?php

        try {
            $this->registerJsFile(
                '@web/js/flashDelay.js',
                ['depends' => [JqueryAsset::class]]);
        } catch (InvalidConfigException $e) {
            throw new \yii\db\Exception($e);
        }

        ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
