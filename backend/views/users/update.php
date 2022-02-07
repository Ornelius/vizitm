<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\Users */

$this->title = 'Update Users: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
