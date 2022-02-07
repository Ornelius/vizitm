<?php


namespace vizitm\forms\manage\address;
use vizitm\entities\address\Street;

use yii\base\Model;

class BuildingnumberCreateForm extends Model
{
    public string $number;
    public int $street_id;

    public function attributeLabels(): array
    {
        return [
            'number' => 'Номер дома',
            ];
    }

    public function rules(): array
    {
        return [
            [['number', 'street_id'], 'required'],
            [['street_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['number'], 'trim'],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::class, 'targetAttribute' => ['street_id' => 'id']],
        ];
    }


}