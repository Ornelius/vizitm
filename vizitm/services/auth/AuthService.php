<?php


namespace vizitm\services\auth;

use vizitm\forms\LoginForm;
use vizitm\entities\Users;
use vizitm\repositories\UserRepository;

class AuthService
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): ? Users
    {
        $user = $this->users->findByUsername($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
           //$this->addError('password', 'Неправильное имя пользователя или пароль.');
            \Yii::$app->getSession()->setFlash('error_user',
                'Неправильный пароль или логин!');
            throw new \DomainException('Неправильный пароль или логин!');
        }
        return $user;
    }


}