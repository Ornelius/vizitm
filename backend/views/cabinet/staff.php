<?php

use vizitm\entities\Users;
use vizitm\helpers\UserHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $model  */
/* @var $user_id */
?>
<?php
$form = ActiveForm::begin([
    'id' => 'staff',
    'enableAjaxValidation'      => true,
    'enableClientValidation'    => true,
    'validationUrl'             => Yii::$app->urlManager->createUrl('/request/valid'),
    'method' => 'POST',
    //'options' => ['id' => 'staff']
    ]);
?>
    <div class="modal-content" >

        <div class="modal-header">
            <h4 class="modal-title text-center">Определить заявку</h4>
        </div>
        <div class="modal-body">
            <?php

                $user = Users::findUserByID(Yii::$app->user->getId());

                if($user->position != Users::POSITION_GL_INGENER) {
                    echo $form->field($model, 'direct_to')->dropDownList([$user->id => $user->lastname],['prompt' => 'Выберите сотрудника']);
                } else {
                    echo $form->field($model, 'direct_to')->dropDownList(UserHelper::ListAllUsersExeptOne($user_id),['prompt' => 'Выберите сотрудника']);
                }



            ?>
            <div class=" view-btn text-left">
                <?= Html::submitButton('Назначить', ['class' => 'btn btn-success' ]) ?>
                <button  type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
<?php ActiveForm::end(); ?>


<?php

?>