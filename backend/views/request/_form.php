<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;

use vizitm\entities\Users;
use vizitm\helpers\RequestHelper;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\web\JqueryAsset;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\Request */
/* @var $photo vizitm\entities\request\Photo */
/* @var $form yii\widgets\ActiveForm */
/* @var $update yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php
    $form = ActiveForm::begin([
            'options' => [
                    'enctype' => 'multipart/form-data',
                    'layout'=>'vertical',
                ],

            //'enableClientValidation' => false,
        ]); ?>

    <?= $form->field($model, 'building_id')->dropDownList(RequestHelper::addressList(), ['prompt' => 'Выберите адрес объекта недвижимости']) ?>

    <?=

    //$form->field($model, 'description')->textarea(['rows' => 4, 'cols' => 5, 'maxlength' => true, 'placeholder' => 'Опишите проблему!'])
    $form->field($model, 'description')->widget(Redactor::class, [
        'clientOptions' => [
            //'imageManagerJson' => ['/redactor/upload/image-json'],
            //'imageUpload' => ['/redactor/upload/image'],
            //'fileUpload' => ['/redactor/upload/file'],
            'lang' => 'ru',
            'buttonsHide' => ['image','file','code'],
            //'plugins' => ['clips', 'fontcolor', 'imagemanager']
        ]
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList(RequestHelper::typeRequestList(), ['prompt' => 'Выберите тип заявки']) ?>

    <?= $form->field($model, 'room')->dropDownList(RequestHelper::roomList(), ['prompt' => 'Выберите место нахождения проблемной ситуации']) ?>

    <?php

    $position = Users::findUserByID(Yii::$app->user->getId())->position;
    if(($position === 3) )//&& $update != true)
        try {
            echo $form->field($model, 'due_date')->widget(DatePicker::class, [
                'value' => date('d.M.Y'),
                'options' => ['placeholder' => 'Выберите дату выполения заявки'],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'startDate' => date('Ymd'), //дата ниже которой нельзя установить значение
                    //'todayBtn' => true, // выбрать сегодняшнюю дату
                    'todayHighlight' => true, // подсветка сегодняшнего дня
                    'autoclose' => true, //авто закрытие
                    'locale' => 'Ru-ru',
                ]
            ]);
        } catch (Exception $e) {
            //throw new NotFoundHttpException($e->getMessage(), 'Не отображает информацию DatePicker');
        }
    ?>

    <?php


    if($update === false) {
        echo '<br><label>Фото и видео материал!</label>';

        try {
            echo $form->field($model->photo, 'files[]')->widget(FileInput::class, [
                //'showMessage' => true,
                'name' => 'InputFileID',
                'attribute' => 'InputFileID',
                'id' => 'fileInputId2',
                'pluginOptions' => [
                    'id' => 'fileInputId1',
                    'showCaption' => true,
                    'showRemove' => true,
                    'showDelete' => true,
                    'showUpload' => false,
                    'showPreview' => true,
                    'overwriteInitial' => true,
                    'initialPreviewAsData' => true,
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="fas fa-trash"></i> ',
                    //'browseClass' => 'btn btn-success btn-block' ,
                    //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ' ,
                    'browseLabel' => 'Добавить ФОТО',
                    'allowedFileExtensions' => [
                        'jpg',
                        'jpeg',
                        'gif',
                        'png',
                        'pdf',
                        'mp4',
                        //'avi'
                    ],
                ],
                'options' => [
                    'accept' => [
                        'image/*',
                        //'video/*'
                    ],
                    'multiple' => true,
                ],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    //echo $form->field($photo, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'video/*'])

    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' =>"submitButton"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
    try {
        $this->registerJsFile('@web/js/blockSave.js', ['depends' => [
            JqueryAsset::class
        ]]);
    } catch (InvalidConfigException $e) {
        echo $e->getMessage();
    }
    ?>
</div>
