<?php

namespace vizitm\entities\address;

use Yii;

/**
 * This is the model class for table "{{%buildingnumber}}".
 *
 * @property int $id
 * @property string $number
 * @property int $street_id
 *
 * @property Building $building
 * @property Street $street
 */
class Buildingnumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%buildingnumber}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'street_id'], 'required'],
            [['street_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
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
            'number' => 'Number',
            'street_id' => 'Street ID',
        ];
    }

    /**
     * Gets query for [[Building]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['buildingnumber_id' => 'id']);
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
}
