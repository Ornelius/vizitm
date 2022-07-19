<?php

namespace vizitm\entities\building;

use vizitm\entities\address\Street;
use vizitm\entities\request\Request;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property int $street_id
 * @property string $buildingnumber
 * @property string $address
 *
 * @property Street $street
 * @property Request $request
 */
class Building extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%building}}';
    }


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

    public static function create(int $street_id, string $buildingnumber, string $address): self
    {
        $building = new static();
        $building->street_id            = $street_id;
        $building->buildingnumber       = $buildingnumber;
        $building->address              = $address;
        return $building;
    }

    /**
     * Gets query for [[Street]].
     *
     * @return ActiveQuery
     */
    public function getStreet(): ActiveQuery
    {
        return $this->hasOne(Street::class, ['id' => 'street_id']);
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest(): ActiveQuery
    {
        return $this->hasMany(Request::class, ['building_id' => 'id']);
    }

    public static function getAddressByID(int $id): string
    {
        return static::find()->where(['id' => $id])->one()->address;
    }

}
