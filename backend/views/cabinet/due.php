<?php

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\request\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $request_status */

$this->title = 'Нераспределенные срочные заявки';
$viewName           = 'due';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('index', [
    'searchModel'           => $searchModel,
    'dataProvider'          => $dataProvider,
    'viewName'              => $viewName
]);
