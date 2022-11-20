<?php

namespace vizitm\entities\address;
use backend\entities\Building;

use yii\db\ActiveRecord;

/***
 * This is the model class for table "{{%street}}".
 *
 * @property int $id
 * @property string $street
 *
 * @property Building[] $building
 */
class Street extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%street}}';
    }

    public function attributeLabels(): array
    {
        return [
            'street' => 'Улица',
        ];
    }

    public static function create(string $streets): self
    {
        $street = new static();
        $street->street           = $streets;
        return $street;
    }
    public function edit($streets): void
    {
       $this->street = $streets;
    }


    /**
     * Gets query for [[Buildingnumbers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasMany(Building::class, ['street_id' => 'id']);
    }
}
