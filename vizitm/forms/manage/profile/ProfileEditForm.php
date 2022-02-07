<?php

namespace vizitm\forms\manage\profile;

use vizitm\entities\Users;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProfileEditForm extends Model
{
    public $id;
    public $name;
    public $lastname;
    public $position;
    public $_user;

    public function __construct(Users $user, $config = [])
    {
            $this->name = $user->name;
            $this->lastname = $user->lastname;
            $this->position = $user->position;



        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'string', 'max' => 255],
            ['lastname', 'string', 'max' => 255],
            ['position', 'integer'],
            [['name', 'lastname'], 'required']
        ];
    }

}