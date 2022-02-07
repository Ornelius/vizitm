<?php

namespace backend\controllers;
use vizitm\entities\address\BuildingnumberSearch;
use vizitm\forms\manage\address\BuildingnumberCreateForm;
use vizitm\services\address\BuildingnumberService;
use Yii;
use yii\web\Controller;

class BuildingnumberController extends Controller
{
    private $service;

    public function __construct(
        $id,
        $module,
        BuildingnumberService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex(): string
    {
        $searchModel = new BuildingnumberSearch();
        $dataProvider = $searchModel->searchById(Yii::$app->request->queryParams);

        return $this->render('index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);

    }

    public function actionCreate()
    {
        $form = new BuildingnumberCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //print_r($form); die();
            try {

                $this->service->createBuildingnumber($form);

                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            //return $this->redirect('index');
            //return $this->redirect(['view', 'id' => $form->id]);
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

}
