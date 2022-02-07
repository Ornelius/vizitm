<?php
namespace vizitm\forms\manage\building;

use yii\base\Model;

class BuildingCreateForm extends Model
{
    public ?string $buildingNumber = null;
    public ?int $street_id = null;

    public function attributeLabels(): array
    {
        return [
            'street_id'             => 'Название улицы',
            'buildingNumber'        => 'Номер дома',
        ];
    }



    public function rules(): array
    {
        return [
            [['buildingNumber', 'street_id'], 'required'],
            [['buildingNumber'], 'string', 'max' => 255],
            ['buildingNumber', 'filter', 'filter' => 'trim'],
            [['street_id'], 'integer'],
        ];
    }

}