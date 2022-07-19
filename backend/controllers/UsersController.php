<?php

namespace backend\controllers;

use vizitm\forms\manage\User\UserCreateForm;
use vizitm\forms\manage\User\UserEditForm;
use vizitm\services\manage\UserManageService;
use Yii;
use vizitm\entities\Users;
use backend\forms\UsersSearch;
use yii\filters\AccessControl;
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
    public bool $bool = false;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        if(Yii::$app->user->getId() != null) {
            $position = Users::findUserByID(Yii::$app->user->getId())->position;
            if($position === Users::POSITION_ADMINISTRATOR)
                $this->bool = true;
        }

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
            'access' => [
                'class' => AccessControl::class,
                'except' => ['error', 'login', 'logout'],
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                        //'ips' => ['192.168.3.5'],
                        'allow' => $this->bool,
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return string
     */
    public function actionIndex(): string
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
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
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
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate(int $id)
    {

        $user = $this->findModel($id);
        $form = new UserEditForm($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
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
     * @return Response
     */
    public function actionDelete(int $id): Response
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

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): ?Users
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
