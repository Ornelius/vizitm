<?php

namespace backend\controllers;

use DomainException;
use vizitm\entities\request\SearchRequest;
use vizitm\forms\manage\request\RequestEditForm;
use vizitm\forms\manage\request\RequestUpdateForm;
use vizitm\forms\manage\request\StaffForm;
use vizitm\services\request\DirectService;
use vizitm\services\request\RequestManageService;
use vizitm\forms\manage\request\RequestCreateForm;
use Yii;
use vizitm\entities\request\Request;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\debug\models\timeline\DataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

header ("Access-Control-Allow-Origin: *");
/**
 * Class RequestController implements the CRUD actions for Request model.
 *
 */
class RequestController extends Controller
{

    private ?RequestManageService $service;
    private ?DirectService $directService;

    public function __construct(
        $id,
        $module,
        RequestManageService    $service,
        DirectService           $directService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service          = $service;
        $this->directService    = $directService;
    }


    /**
     * {}
     */
    public function behaviors(): array
    {
        return [

            'verbs' => [
               'class' => VerbFilter::class,
                'actions' => [
                    'index'     => ['GET', 'POST'],
                    'delete'    => ['POST'],
                    'valid'     => ['GET', 'POST'],
                    'direct'    => ['GET', 'POST'],
                    'new'       => ['GET', 'POST'],
                    'create'    => ['GET', 'POST'],
                    'update'    => ['GET', 'POST'],
                ],

            ],
        ];
    }

    /**
     * Lists all Request models.
     * @return string
     */
    public function actionNew(): string
    {
        $searchModel = new SearchRequest();
        $request_status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request_status);

        return $this->render('new', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
        ]);
    }

    /**
     * Lists all Request models.
     * @return string
     */
    public function actionWork(): string
    {
        $searchModel = new SearchRequest();
        $request_status= 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request_status);

        return $this->render('work', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
        ]);
    }

    /**
     * Lists all Request models.
     * @return Response|string
     */
    public function actionDirect(int $id, string $viewName)
    {
        //$this->enableCsrfValidation = false;
        $form = new StaffForm();
        $post = Yii::$app->request->post();
        $del_user_from_menu_id = Request::find()->where(['id'=>$id])->one()->work_whom;

        if ($form->load($post) && $form->validate()) {
            $this->service->requestWork($id, $form);

            $this->directService->createDirect($id, $form);
            return $this->redirect([$viewName]);
        }


        return $this->renderAjax('staff', [
            'model'         => $form,
            'user_id'    => $del_user_from_menu_id,
        ]);

    }
    public function actionValid()
    {
        if (Yii::$app->getRequest()->isAjax ) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $form_model = new StaffForm();
            $post = Yii::$app->request->post();
            $form_model->load($post);

            return ActiveForm::validate($form_model);
        }
        return false;

    }

    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionDone(): ?string /** Выполненные заявки!  */
    {
        $searchModel = new SearchRequest();
        $request_status= 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request_status);

        return $this->render('done', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            //'request_status'            => $request_status,
        ]);
    }
    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionRequestDone(int $id, string $viewName) /** Создание выполненной заявки */
    {
        $form = new RequestUpdateForm();
        if ($form->load(Yii::$app->request->post())) {
            $form->photo->validate();
            $isValid = $form->validate();

            if ($isValid) {
                try{
                    $this->service->requestDone($form, $id);
                    return $this->redirect([$viewName]);
                } catch (DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('work_done', [
            'model' => $form,
        ]);

    }


    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionDue() /** Меню срочная заявка */
    {
        $searchModel = new SearchRequest();
        $request_status = 4;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request_status);

        return $this->render('due', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            //'request_status'        => $request_status,
        ]);
    }

    public function actionDuework()
        /** Меню срочная заявка */
    {
        $searchModel = new SearchRequest();
        $request_status = 5;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request_status);

        return $this->render('duework', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider
        ]);
    }



    /**
     * Displays a single Request model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id, string $viewName): string
    {
        $request = $this->findModel($id);
        return $this->render('view', [
            'model' => $request,
            'viewNmae' => $viewName,
        ]);
    }

    /**
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     */
    public function actionCreate()
    {

        $form = new RequestCreateForm();
        if ($form->load(Yii::$app->request->post())) {
            $form->photo->validate();
            $isValid = $form->validate();

            if ($isValid) {
                try {
                    //print_r(date('Y-m-d H:i:s', $form->due_date )); die();
                    $this->service->createRequest($form);
                    return $this->redirect(['request/new']);
                } catch (DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);


    }

    /**
     * Updates an existing Request model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     */
    public function actionUpdate(int $id, string $viewName)
    {
        $request = $this->findModel($id);
        $form = new RequestEditForm($request);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($form, $id);
            return $this->redirect(['request/' . $viewName]);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }


    /**
     * Deletes an existing Request model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $viewName
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id, string $viewName): Response /** @var  $model */
    {
            $model = $this->findModel($id);
            $model->deleted = true;
            $model->deleted_at = time();
            $model->save();
            Yii::$app->getSession()->setFlash('success', 'Заявка №' . $model->id . ' Удалена!' );

        return $this->redirect(['request/' . $viewName]);
    }

    /**
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): ?Request
    {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
