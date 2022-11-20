<?php
namespace vizitm\forms;

use yii\base\Model;
use vizitm\entities\Users;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            //['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }
    public function validatePassword()
    {
        $user = Users::findByUsername($this->username);

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Неправильное имя пользователя или пароль.');
        }
    }

    public function attributeLabels()
    {
        return [
            'username'          => 'Имя пользователя',
            'password'          => 'Пароль',
        ];
    }

}
