<?php


namespace backend\forms\Users;


use yii\base\Model;

class UsersForm
{

    public function attributeLabels()
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
            [['id', 'status', 'created_at', 'updated_at', 'role'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', /*'firstname', 'lastname',*/ 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

}