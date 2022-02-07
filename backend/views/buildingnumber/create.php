<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vizitm\entities\address\Buildingnumber */

$this->title = 'Create Buildingnumber';
$this->params['breadcrumbs'][] = ['label' => 'Buildingnumbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buildingnumber-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
