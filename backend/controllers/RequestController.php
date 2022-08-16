<?php

namespace backend\controllers;

use DomainException;
use vizitm\entities\request\SearchRequest;
use vizitm\forms\manage\comments\CommentsForm;
use vizitm\forms\manage\request\RequestEditForm;
use vizitm\forms\manage\request\RequestUpdateForm;
use vizitm\forms\manage\request\StaffForm;
use vizitm\services\comments\CommentService;
use vizitm\services\request\DirectService;
use vizitm\services\request\RequestManageService;
use vizitm\forms\manage\request\RequestCreateForm;
use Yii;
use vizitm\entities\request\Request;
use yii\bootstrap4\ActiveForm;
use yii\db\StaleObjectException;
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

    private ?RequestManageService   $service;
    private ?DirectService          $directService;
    private  CommentService         $commentService;

    public function __construct(
        $id,
        $module,
        RequestManageService    $service,
        DirectService           $directService,
        CommentService          $commentService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service          = $service;
        $this->directService    = $directService;
        $this->commentService   = $commentService;
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
                    'duework'    => ['GET', 'POST'],
                    'commentsv'    => ['GET', 'POST'],
                    'comments'    => ['GET', 'POST'],
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('work', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
        ]);
    }

    /**
     * Lists all Request models.
     * @return Response|string
     * @throws StaleObjectException
     */
    public function actionDirect(int $id, string $viewName)
    {
        //$this->enableCsrfValidation = false;
        $form = new StaffForm();
        $post = Yii::$app->request->post();

        if ($form->load($post) && $form->validate()) {
            $this->service->requestWork($id, $form);
            $this->directService->createDirect($id, $form);
            if($form->comment->load($post) && $form->comment->validate())
                if(!empty($form->comment->comment))
                    $this->commentService->createComment($id, Yii::$app->user->getId(), $form->comment);
            return $this->redirect([$viewName]);
        }


        return $this->renderAjax('staff', [
            'model'         => $form,
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('done', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
        ]);
    }

    /**
     * Lists all Request models.
     * @return Response|string
     * @throws StaleObjectException
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
     * @return string
     */
    public function actionDue(): string
        /** Меню срочная заявка */
    {
        $searchModel = new SearchRequest();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('due', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Request model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return string
     */

    public function actionDuework(): string
        /** Меню срочная заявки в работе */
    {
        $searchModel = new SearchRequest();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionView(int $id): string
    {
        $request = $this->findModel($id);
        return $this->render('view', [
            'model' => $request,
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
     * @param string $viewName
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
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


    public function actionComments(int $id, string $viewName)
    {
        $form = new CommentsForm();
        $post = Yii::$app->request->post();
        if ($form->load($post) && $form->validate()) {
                if(!empty($form->comment))
                    $this->commentService->createComment($id, Yii::$app->user->getId(), $form );
            return $this->redirect(['request/' . $viewName]);
        }


        return $this->renderAjax('comments',[
            'id'                => $id,
            'model'             => $form,
        ]);

    }
    public function actionCommentsv()
    {
        if (Yii::$app->getRequest()->isAjax ) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $form_model = new CommentsForm();
            $post = Yii::$app->request->post();
            $form_model->load($post);
            return ActiveForm::validate($form_model);
        }
        return false;

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
