<?php

use vizitm\entities\comments\Comments;
use vizitm\entities\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use vizitm\entities\comments\rendomColor;

/* @var $model  */
/* @var $user_id */
/* @var $id */
/* @var $viewName */

$form = ActiveForm::begin([
    'id' => 'commentsAjax',
    'enableAjaxValidation'      => true,
    'enableClientValidation'    => true,
    'validationUrl'             => Yii::$app->urlManager->createUrl('/request/commentsv'),
    'method' => 'POST',
    //'options' => ['id' => 'staff']
]);
?>
<div class="modal-content" >

    <div class="modal-header">
        <h4 class="modal-title text-center">Комментарий к заявке</h4>
    </div>
    <div class="modal-body">
        <?php
        if($comments = Comments::findCommentsByRequestID($id))
        {
            $array = [];
            foreach ($comments as $comment)
            {
                $array += [$comment->user_id => rendomColor::randColor()] ;
                $user = Users::findUserByIDNotActive($comment->user_id);

                echo '<div style="background:  ' . ArrayHelper::getValue($array, $comment->user_id) .  ' ; border-style: none; padding: 10px;  border-radius: 10px;">
                        <span class="time" style="font-size: x-small;">
                            <i class="far fa-clock"> '. date("d-m-Y H:i:s", $comment->datetime). "   " .'</i>
                            <i class="far fa-user"> ' . $user->lastname . ':</i>
                        </span>
                        <span><p>'
                    . $comment->comment .
                    '</p></span>
                        </div><p>';
            }
        }


        echo $form->field($model, 'comment')->textarea(['rows' => 4, 'cols' => 5, 'maxlength' => true, 'placeholder' => 'Оставьте комментарий']);



        ?>
        <div class=" view-btn text-left">
            <?= Html::submitButton('Оставить', ['class' => 'btn btn-success' ]) ?>
            <button  type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>

