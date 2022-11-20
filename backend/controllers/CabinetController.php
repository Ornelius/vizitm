<?php


namespace backend\controllers;


use vizitm\entities\building\BuildingSearch;
use Yii;
use yii\web\Controller;

class CabinetController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new BuildingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}