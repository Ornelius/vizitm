<?php

namespace vizitm\forms\manage\User;

use vizitm\entities\Users;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserEditForm extends Model
{
    public ?int         $id         = null;
    public ?string      $username   = null;
    public ?string      $email      = null;
    public ?int         $status     = null;
    public ?string      $password   = null;
    public Users        $_user;

    public function __construct(Users $user, $config = [])
    {
        //$this->id       = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        //$roles = Yii::$app->authManager->getRolesByUser($user->id);
        //$this->role = $roles ? reset($roles)->name : null;
        //$this->password = $user->password_hash;
        //$this->auth_key = $user->auth_key;
        $this->status = $user->status;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['email'], 'email'],
            ['email', 'string', 'max' => 255],
            ['status', 'integer'],
            [['password'], 'string', 'min' => 6],
            [['username', 'email'],'unique', 'targetClass' => Users::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}