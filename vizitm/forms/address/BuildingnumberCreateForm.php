<?php


namespace vizitm\forms\manage\address;


use yii\base\Model;

class BuildingnumberCreateForm extends Model
{
    public $number;

    public function attributeLabels(): array
    {
        return [
            'number' => 'Номер дома',
            ];
    }

    public function rules(): array
    {
        return [
            ['number', 'required'],
            [['number'], 'string', 'max' => 255],
        ];
    }


}