<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\address\Street */

$this->title = 'Добавить подчиненного';
$this->params['breadcrumbs'][] = ['label' => 'Подчинненные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slaves-create">
    <?php if (Yii::$app->session->hasFlash('error')):  ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation-circle" aria-hidden="true"> <?= Yii::$app->session->getFlash('error') ?></i>
        </div>
    <?php endif; ?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
