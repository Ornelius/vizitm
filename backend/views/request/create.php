<?php

/* @var $this yii\web\View */
/* @var $model vizitm\entities\request\Request */
/* @var $photoForm vizitm\entities\request\Photo */

$this->title = 'Создание заявки';
$this->params['breadcrumbs'][] = ['label' => 'Текущие заявки', 'url' => ['new']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>