<?php


namespace backend\controllers;


use yii\base\BaseObject;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WarehausController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Street models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new StreetSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        echo 'denis111'; die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}