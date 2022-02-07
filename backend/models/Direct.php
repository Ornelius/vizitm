<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%direct}}".
 *
 * @property int $id
 * @property int $request_id
 * @property int|null $direct_datetime
 * @property int|null $direct_from
 * @property int|null $direct_to
 *
 * @property Request $request
 */
class Direct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%direct}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id'], 'required'],
            [['request_id', 'direct_datetime', 'direct_from', 'direct_to'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'request_id' => Yii::t('app', 'Request ID'),
            'direct_datetime' => Yii::t('app', 'Direct Datetime'),
            'direct_from' => Yii::t('app', 'Direct From'),
            'direct_to' => Yii::t('app', 'Direct To'),
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
