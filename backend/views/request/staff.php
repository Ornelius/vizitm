<?php

use vizitm\entities\Users;
use vizitm\helpers\UserHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $model  */
/* @var $user_id */

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
                echo $form->field($model, 'direct_to')->dropDownList(UserHelper::ListSlavesUsers(Yii::$app->user->getId()),['prompt' => 'Выберите сотрудника']);
                echo $form->field($model->comment, 'comment')->textarea(['rows' => 4, 'cols' => 5, 'maxlength' => true, 'placeholder' => 'Оставьте комментарий']);



            ?>
            <div class=" view-btn text-left">
                <?= Html::submitButton('Назначить', ['class' => 'btn btn-success' ]) ?>
                <button  type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
<?php ActiveForm::end(); ?>
