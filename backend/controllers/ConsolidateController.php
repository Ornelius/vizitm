<?php


namespace backend\controllers;

use backend\entities\SearchConsolidate;
use Yii;
use yii\web\Controller;

class ConsolidateController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new SearchConsolidate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}