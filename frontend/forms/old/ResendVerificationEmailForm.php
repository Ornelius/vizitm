<?php


namespace frontend\forms;

use Yii;
use vizitm\entities\Users;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
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
                'filter' => ['status' => Users::STATUS_INACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }
}
