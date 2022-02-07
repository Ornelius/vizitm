<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%request}}".
 *
 * @property int $id
 * @property int $building_id
 * @property int $user_id
 * @property string $description
 * @property int $created_at
 * @property string $type
 * @property int|null $deleted
 * @property int|null $deleted_at
 * @property int|null $done
 * @property int|null $done_at
 * @property int|null $invoice
 * @property int|null $invoce_at
 * @property string|null $description_done
 *
 * @property Direct $direct
 * @property Photo $photo
 * @property Building $building
 * @property Users $user
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
            [['building_id', 'user_id', 'description', 'created_at', 'type'], 'required'],
            [['building_id', 'user_id', 'created_at', 'deleted', 'deleted_at', 'done', 'done_at', 'invoice', 'invoce_at'], 'integer'],
            [['description', 'type', 'description_done'], 'string', 'max' => 255],
            [['building_id'], 'unique'],
            [['user_id'], 'unique'],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::className(), 'targetAttribute' => ['building_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'building_id' => Yii::t('app', 'Building ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'type' => Yii::t('app', 'Type'),
            'deleted' => Yii::t('app', 'Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'done' => Yii::t('app', 'Done'),
            'done_at' => Yii::t('app', 'Done At'),
            'invoice' => Yii::t('app', 'Invoice'),
            'invoce_at' => Yii::t('app', 'Invoce At'),
            'description_done' => Yii::t('app', 'Description Done'),
        ];
    }

    /**
     * Gets query for [[Direct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirect()
    {
        return $this->hasOne(Direct::className(), ['request_id' => 'id']);
    }

    /**
     * Gets query for [[Photo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Photo::className(), ['request_id' => 'id']);
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
