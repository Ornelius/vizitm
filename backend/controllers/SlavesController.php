<?php


namespace backend\controllers;

use vizitm\entities\slaves\SlavesSearch;
use vizitm\forms\slaves\SlavesForm;
use vizitm\services\slaves\SlavesServices;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * StreetController implements the CRUD actions for Street model.
 */
class SlavesController extends Controller
{
    private ?SlavesServices $service = null;
    public function __construct(
        $id,
        $module,
        SlavesServices $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Street models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new SlavesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Street model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new SlavesForm();

        if ($form->load(Yii::$app->request->post())) {
            //$form->master_id = Yii::$app->user->identity->id;
            if($form->validate())
            try{
                $this->service->create($form) ;
                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            throw new \DomainException('Валидация не прошла');
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }


    /**
     * @throws StaleObjectException
     */
    public function actionDelete($id): Response
    {
        $this->service->remove($id);
        return $this->redirect(['index']);
    }
}
