<?php

namespace backend\controllers;

use vizitm\forms\manage\profile\ProfileEditForm;
use vizitm\services\manage\UserManageService;
use Yii;
use vizitm\entities\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DomainException;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{

    private $service;

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
    public function behaviors()
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
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $form = new ProfileEditForm($user);
        //print_r(Yii::$app->request->post()); die();
        if ($form->load(Yii::$app->request->post()) && $form->validate())
        {
            try {

                $this->service->editProfile($user->id, $form);
                return $this->redirect(['users/index']);
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
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Users
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
