<?php
namespace vizitm\forms\slaves;

use yii\base\Model;

class Slaves extends Model
{
    public $master_id;
    public $slave_id;

    public function attributeLabels(): array
    {
        return [
            'master_id'     => 'Начальник',
            'slave_id'      => 'Подчиненный',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['master_id','slave_id'], 'required'],
            [['master_id','slave_id'], 'integer'],
        ];
    }

}