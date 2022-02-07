<?php


namespace vizitm\services\auth;
use vizitm\repositories\UserRepository;
use vizitm\entities\Users;
use vizitm\forms\manage\User\UserCreateForm;

class SignupService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function signup(UserCreateForm $form): ? Users
    {
        if ( $this->users->findByUsername($form->username)) {
            throw new \DomainException('Пользователь с таким именем уже существует!');
        }

        $user = Users::signup(
            $form->username,
            $form->email,
            $form->password
            //$form->status
        );
        $this->users->save($user);

        return $user;
    }

}