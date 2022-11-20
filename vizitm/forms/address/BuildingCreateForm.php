<?php


namespace vizitm\forms\manage\address;


use vizitm\entities\address\Street;
use yii\base\Model;

class BuildingCreateForm extends Model
{
    public int $street;
    public int $number;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'street_id' => 'Street ID',
            'address' => 'Address',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['street_id', 'address'], 'required'],
            [['street_id'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['street_id'], 'unique'],
            [['address'], 'unique'],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::class, 'targetAttribute' => ['street_id' => 'id']],
        ];
    }

}