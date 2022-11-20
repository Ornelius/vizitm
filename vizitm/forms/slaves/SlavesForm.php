<?php
namespace vizitm\forms\slaves;

use vizitm\entities\slaves\Slaves;
use yii\base\Model;

class SlavesForm extends Model
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

    public function __construct(Slaves $slave = null, $config = [])
    {
        if($slave) {
            $this->master_id = $slave->master_id;
            $this->slave_id = $slave->slave_id;
        }
        parent::__construct($config);
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