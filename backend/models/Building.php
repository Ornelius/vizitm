<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property int $street_id
 * @property string $address
 *
 * @property Street $street
 * @property Request $request
 */
class Building extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['street_id', 'address'], 'required'],
            [['street_id'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['street_id'], 'unique'],
            [['address'], 'unique'],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::className(), 'targetAttribute' => ['street_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'street_id' => 'Street ID',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Street]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStreet()
    {
        return $this->hasOne(Street::className(), ['id' => 'street_id']);
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['building_id' => 'id']);
    }
}
