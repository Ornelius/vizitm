<?php

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\Request */

$this->title = 'Заявка №' .  $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['new']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование заявки №' .  $model->id;
?>
<div class="request-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => true
    ]); ?>

</div>
