<?php

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\request\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $request_status */

use yii\helpers\Html;

$this->title = 'Текущие заявки';
    $viewName           = 'new';

$this->params['breadcrumbs'][] = $this->title;

?>
    <p>
        <?= Html::a( 'Новая заявка', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

<?= $this->render('index', [
    'searchModel'           => $searchModel,
    'dataProvider'          => $dataProvider,
    'viewName'              => $viewName,
]);




