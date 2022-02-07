<?php

namespace vizitm\entities\building;

use Yii;

/**
 * This is the model class for table "{{%request}}".
 *
 * @property int $id
 * @property string $description
 * @property int|null $building_id
 *
 * @property Building $building
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['building_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['building_id'], 'unique'],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::className(), 'targetAttribute' => ['building_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'building_id' => 'Building ID',
        ];
    }

    /**
     * Gets query for [[Building]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['id' => 'building_id']);
    }
}
