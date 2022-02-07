<?php


namespace vizitm\forms\manage\address;


use yii\base\Model;

class StreetCreateForm extends Model
{
    public ?string $street = null;

    public function attributeLabels(): array
    {
        return [
            'street' => 'Название улицы'
        ];
    }

    public function rules(): array
    {
        return [
            ['street', 'required' ],
            [['street'], 'string', 'max' => 255 ],
            [['street'], 'filter', 'filter' => 'trim', 'skipOnArray' => true ]
        ];
    }

}