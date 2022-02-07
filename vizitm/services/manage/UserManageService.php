<?php
namespace vizitm\services\manage;
use DomainException;
use vizitm\entities\Users;
use vizitm\forms\manage\profile\ProfileEditForm;
use vizitm\forms\manage\User\UserCreateForm;
use vizitm\repositories\UserRepository;
use vizitm\forms\manage\User\UserEditForm;

class UserManageService
{
    private ?UserRepository  $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser(UserCreateForm $form): Users
    {
        if ( $this->repository->findByUsername($form->username)) {
            throw new DomainException('Пользователь с таким именем уже существует!');
        } elseif (!$form->email) {
            throw new DomainException('Заполните поле e-mail!');
        } elseif ($this->repository->findByEmail($form->email)) {
            throw new DomainException('Пользователь с таким e-mail уже существует!');
        } else{
            $user = Users::signup(
                $form->username,
                $form->email,
                $form->password
            );
            $this->repository->save($user);
            return $user;

        }

    }
    public function edit($id, UserEditForm $form): void
    {

        $user = $this->repository->get($id);

        $user->edit(
            $form->username,
            $form->email,
            $form->password,
            $form->status
        );

        $this->repository->save($user);
    }

    public function editProfile($id, ProfileEditForm $form): void
    {

        $user = $this->repository->get($id);

        $user->editProfile(
            $form->name,
            $form->lastname,
            $form->position
        );

        $this->repository->save($user);
    }



    public function setStatusInactive(int $id): void
    {
        $user = $this->repository->findById($id);
        $user->statusInactive();
        $this->repository->save($user);
    }
    public function setStatusActive(int $id): void
    {
        $user = $this->repository->findById($id);
        $user->statusActive();
        $this->repository->save($user);
    }

    public function deleteUser($id): void
    {
        $this->repository->deleteUsers($id);
    }
    public function findUserById(int $id): Users
    {
        return $this->repository->findById($id);

    }

}