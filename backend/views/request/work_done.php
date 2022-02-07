<?php

use kartik\file\FileInput;
use vizitm\helpers\RequestHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\Request */
/* @var $photo vizitm\entities\request\Photo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'layout'=>'vertical',
        ],
    ]); ?>

    <?= $form->field($model, 'done_description')->textarea(['rows' => 4, 'cols' => 5, 'maxlength' => true, 'placeholder' => 'Опешите проблему!'])

    ?>


    <?php

    echo '<br><label>Фото и видео материал</label>';

    echo $form->field($model->photo, 'files[]')->widget(FileInput::class, [
        'showMessage' => false,
        'name' => 'files[]',
        'attribute' => 'files[]',
        'pluginOptions' => [
            'id' => 'fileInputId1',
            'showCaption' => true ,
            'showRemove' => true ,
            'showDelete' => true ,
            'showUpload' => false ,
            'showPreview' => true ,
            'overwriteInitial'=> true,
            'initialPreviewAsData'=> true,
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="fas fa-trash"></i> ',
            //'browseClass' => 'btn btn-success btn-block' ,
            //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ' ,
            'browseLabel' => 'Добавить ФОТО',
            'allowedFileExtensions'=> [
                'jpg',
                'jpeg',
                'gif',
                'png',
                'pdf',
                'mp4',
                //'avi'
            ],
        ] ,
        'options' => [
            'accept' => [
                'image/*',
                //'video/*'
            ],
            'multiple'=>true,
        ],
    ]);

    //echo $form->field($photo, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'video/*'])


    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
