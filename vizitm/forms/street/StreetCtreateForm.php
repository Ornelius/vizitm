<?php


namespace vizitm\forms\street;


use yii\base\Model;

class StreetCtreateForm extends Model
{
    public $street;

    public function attributeLabels(): array
    {
        return [
            'street'                   => 'Название улицы',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['street', 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }





}