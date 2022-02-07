<?php
namespace vizitm\forms\auth;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $role;

    public function attributeLabels()
    {
        return [
            'username'          => 'Имя пользователя',
            'email'             => 'Ваш электронный адрес (e-mail)',
            'password'          => 'Пароль',
            //'firstname'         => 'Ваше имя',
            //'lastname'          => 'Ваша фамилия',
            'role'              => 'Должность (Роль)',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\entities\Users', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['role', 'trim'],
        ];
    }
}
