<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property int $id
 * @property int $request_id
 * @property string $path
 * @property int|null $type
 *
 * @property Request $request
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%photo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'path'], 'required'],
            [['request_id', 'type'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['request_id'], 'unique'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'path' => 'Path',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }
}
