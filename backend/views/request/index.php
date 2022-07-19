<?php

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\request\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $request_status */
/* @var $hasNew */
/* @var $hasWork */
/* @var $hasDone */
/* @var $hasDeu */
/* @var $hasDeuWork */
/* @var $viewName */

use vizitm\entities\Users;
use vizitm\services\request\RequestViewManage;
use yii\base\InvalidConfigException;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

//$hasNew             = false;
//$hasWork            = false;
//$hasDone            = false;
//$hasDeu             = false;
//$hasDeuWork         = false;
//$position = Users::findUserByIDNotActive(Yii::$app->user->getId())->position;
$content = new RequestViewManage();
//$viewName = Yii::$app->controller->action->id;

/*if($viewName === 'work')
{
    $hasWork = true;
} elseif ($viewName === 'done')
{
    $hasDone = true;
} elseif ($viewName === 'duework')
{
    if(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR))
        $hasDeuWork = true;
}*/

?>
<div class="modal intermodal staff" id="staffForm" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md "></div>
</div>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible" id="successMessage">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i><?= Yii::$app->session->getFlash('success') ?></h5>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('wrong')): ?>
    <div class="alert alert-success alert-dismissible" id="wrongMessage">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i><?= Yii::$app->session->getFlash('wrong') ?></h5>
    </div>
<?php endif; ?>

<div class="request-index">
    <?php
    Pjax::begin();
    try {
        $content->setContent(
            $dataProvider,
            $searchModel,
            //$hasWork,
            //$hasDone,
            //$hasDeuWork,
            //Yii::$app->controller->action->id
        );
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    echo $content->getContent();
    Pjax::end();
    ?>
    <!-- POPUP MODAL CONTACT -->
    <div class="modal" id="addStaffFormModel" role="dialog">
        <div class="modal-dialog modal-md "></div>
    </div>

    <?php

    try {
        $this->registerJsFile(
            '@web/js/ajaxForm.js',
            ['depends' => [JqueryAsset::class]]);

    } catch (InvalidConfigException $e) {
        throw new \yii\db\Exception($e);
    }
    try {
        $this->registerJsFile(
            '@web/js/staffModal.js',
            ['depends' => [JqueryAsset::class]]);
    } catch (InvalidConfigException $e) {
        throw new \yii\db\Exception($e);
    }
    try {
        $this->registerJsFile(
            '@web/js/flashDelay.js',
            ['depends' => [JqueryAsset::class]]);
    } catch (InvalidConfigException $e) {
        throw new \yii\db\Exception($e);
    }

    ?>

</div>


