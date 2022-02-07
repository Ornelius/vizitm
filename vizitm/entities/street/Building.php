<?php

namespace vizitm\entities\street;

use Yii;

/**
 * This is the model class for table "{{%building}}".
 *
 * @property int $id
 * @property string $number
 * @property string $year_of_building
 * @property int $number_of_floors
 * @property int $zero_floor
 * @property int $number_of_section
 * @property int $number_of_aparnment
 * @property float $area_of_building
 * @property float $area_of_floors
 * @property int $number_of_lifts
 * @property int $number_of_trash_chute
 * @property string $PPA
 * @property int $office_flore
 * @property int $kotelnaya
 * @property int $boilernaya
 * @property int $pumps
 * @property int $street_id
 *
 * @property Street $street
 */
class Building extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['number', 'year_of_building', 'number_of_floors', 'zero_floor', 'number_of_section', 'number_of_aparnment', 'area_of_building', 'area_of_floors', 'number_of_lifts', 'number_of_trash_chute', 'PPA', 'office_flore', 'kotelnaya', 'boilernaya', 'pumps', 'street_id'], 'required'],
            [['number_of_floors', 'zero_floor', 'number_of_section', 'number_of_aparnment', 'number_of_lifts', 'number_of_trash_chute', 'office_flore', 'kotelnaya', 'boilernaya', 'pumps', 'street_id'], 'integer'],
            [['area_of_building', 'area_of_floors'], 'number'],
            [['number', 'year_of_building', 'PPA'], 'string', 'max' => 255],
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
            'year_of_building' => 'Year Of Building',
            'number_of_floors' => 'Number Of Floors',
            'zero_floor' => 'Zero Floor',
            'number_of_section' => 'Number Of Section',
            'number_of_aparnment' => 'Number Of Aparnment',
            'area_of_building' => 'Area Of Building',
            'area_of_floors' => 'Area Of Floors',
            'number_of_lifts' => 'Number Of Lifts',
            'number_of_trash_chute' => 'Number Of Trash Chute',
            'PPA' => 'Ppa',
            'office_flore' => 'Office Flore',
            'kotelnaya' => 'Kotelnaya',
            'boilernaya' => 'Boilernaya',
            'pumps' => 'Pumps',
            'street_id' => 'Street ID',
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
}
