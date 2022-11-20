<?php

/* @var $this yii\web\View */
/* @var $searchModel vizitm\entities\request\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выполненные заявки';


$this->params['breadcrumbs'][] = $this->title;

echo $this->render('index', [
    'searchModel'           => $searchModel,
    'dataProvider'          => $dataProvider,
]);


