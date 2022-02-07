<?php

namespace backend\controllers;

use vizitm\forms\manage\User\UserCreateForm;
use vizitm\forms\manage\User\UserEditForm;
use vizitm\services\manage\UserManageService;
use Yii;
use vizitm\entities\Users;
use backend\forms\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DomainException;
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    private UserManageService $service;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new UserCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->createUser($form);
                return $this->redirect('index');
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate(int $id)
    {

        $user = $this->findModel($id);
        $form = new UserEditForm($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //print_r(Yii::$app->request->post()); die();
            try{
                $this->service->edit($user->id, $form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }



            return $this->redirect(['view', 'id' => $form->id]);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        $this->service->deleteUser($id);
        return $this->redirect(['index']);
    }

    public function actionInactive(int $id): Response
    {
        $this->service->setStatusInactive($id);
        return $this->redirect(['index']);
    }
    public function actionActive(int $id): Response
    {
        $this->service->setStatusActive($id);
        return $this->redirect(['index']);
    }

    protected function findModel(int $id): ?Users
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


    }
}
