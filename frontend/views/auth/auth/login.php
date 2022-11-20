<?php

/* @var $this yii\web\View */

$this->title = 'Визит-М';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="wrap">
    <div class="container">
<div class="video-content">
    <div class="video-background">
        <video id="video-content" class="video-foreground" poster="/images/1.png" autoplay muted loop>
            <source src="/video/hd720.mp4" type="video/mp4">
        </video>
    </div>
</div>

<div class="site"></div>

<div class="site-index">


    <div class="jumbotron">
        <h1 class="font_meie_script">ООО "Визит-М"</h1>

    </div>

    <div class="body-content jumbotron" style="border-radius: 8px;">

        <div class="row" style="text-align: left;">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['placeholder'=>"Пользователь", 'autocomplete' =>'off'])->label('')->error(['style' =>'color: #ff0000']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder'=>"Пароль"])->label('')->error(['style' =>'color: #ff0000']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить') ?>



                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'mybtn', 'name' => 'login-button',]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
</div>
</div>