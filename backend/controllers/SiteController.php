<?php
namespace backend\controllers;

//use backend\forms\Users\UsersForm;
//use vizitm\forms\auth\Users;
use DomainException;
use vizitm\forms\manage\User\UserCreateForm;
use vizitm\services\auth\AuthService;
use vizitm\services\auth\SignupService;
use Yii;
use yii\web\Controller;
use vizitm\forms\LoginForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @var mixed
     */
    private $authService;
    private $signupService;


    public function __construct(
        $id,
        $module,
        AuthService $authService,
        SignupService $signupService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->signupService = $signupService;
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            //$this->layout = 'custom-error-layout';
            $this->actionLogin();
        }
        return parent::beforeAction($action);
    }



    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }


        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goBack();
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $form = new UserCreateForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->signupService->signup($form);
                return $this->goBack();
            }
            catch (DomainException $e) {
        Yii::$app->session->setFlash('error', $e->getMessage());
    }
        }
        return $this->render('signup', [
            'model' => $form,
        ]);

    }
}
