<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\Users */

$this->title = 'Update Profile: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
