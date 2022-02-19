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
use yii\bootstrap4\LinkPager;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

$hasNew             = false;
$hasWork            = false;
$hasDone            = false;
$hasDeu             = false;
$hasDeuWork         = false;
$position = Users::findUserByID(Yii::$app->user->getId())->position;
$content = new RequestViewManage();
if($viewName === 'work')
{
    if(($position === 3) || ($position === 6))
        $hasWork = true;
} elseif ($viewName === 'done')
{
    $hasDone = true;
} elseif ($viewName === 'duework')
{
    if(($position === 3) || ($position === 6))
        $hasDeuWork = true;
}

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

<div class="request-index">
    <?php
    Pjax::begin();
    try {
        $content->setContent(
            $dataProvider,
            $searchModel,
            //$hasNew,
            $hasWork,
            $hasDone,
            //$hasDeu,
            $hasDeuWork,
            $viewName);
    } catch (Exception $e) {
        //print_r($e->getMessage());
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


