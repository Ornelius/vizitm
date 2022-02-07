<?php


namespace vizitm\forms\manage\request;
use yii\base\Model;

class StaffForm extends Model
{

    public $direct_to;


    public function attributeLabels(): array
    {
        return [
            'direct_to'           => 'Назначить сотрудника',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['direct_to'], 'required'],
            [['direct_to'], 'integer'],
        ];
    }

}