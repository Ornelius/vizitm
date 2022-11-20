<?php
namespace vizitm\forms\auth;

use yii\base\Model;
use vizitm\entities\Users;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => Users::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }
}
