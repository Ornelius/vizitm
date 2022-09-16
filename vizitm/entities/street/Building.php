<?php

namespace vizitm\entities\street;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%building}}".
 *
 * @property int $id
 * @property int $street_id
 * @property string $buildingnumber
 * @property string $address
 * @property Street $street
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
    public function rules(): array
    {
        return [
            [[ 'street_id'], 'required'],
            [['street_id'], 'integer'],
            [['buildingnumber'], 'max' => 255],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::class, 'targetAttribute' => ['street_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'                => 'ID',
            'street_id'         => 'Street ID',
            'buildingnumber'    => 'Номер улицы',
            'address'           => 'Адрес',
        ];
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
}
