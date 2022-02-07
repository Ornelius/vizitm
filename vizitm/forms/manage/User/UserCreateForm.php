<?php
namespace vizitm\forms\manage\User;
use yii\base\Model;

class UserCreateForm extends Model
{
    public ?string $username    = null;
    public ?string $email       = null;
    public ?string $password    = null;
    public ?int $status         = null;
    public ?string $name        = null;
    public ?string $lastname    = null;
    public ?string $position    = null;



    public function attributeLabels(): array
    {
        return [
            'username'          => 'Имя пользователя',
            'email'             => 'Ваш электронный адрес (e-mail)',
            'password'          => 'Пароль',
            'name'              => 'Имя сотрудника',
            'lastname'          => 'Фамлия сотрудника',
            'position'          => 'Должность сотрудника',
            'status'            => 'Статус',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\entities\Users', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 255],

            ['email', 'trim'],
            //['email', 'unique', 'targetClass' => '\vizitm\entities\Users', 'message' => 'This e-mail has already been taken.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            //['status', 'required'],
            ['status', 'integer'],

            //['name', 'trim'],
            //['name', 'string', 'max' => 255],

            //['lastname', 'trim'],
            //['lastname', 'string', 'max' => 255],

            //['position', 'integer'],

        ];
    }


}