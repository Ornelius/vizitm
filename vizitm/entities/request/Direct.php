<?php

namespace vizitm\entities\request;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Direct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%direct}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            //[['request_id'], 'required'],
            //[['request_id', 'direct_datetime', 'direct_from', 'direct_to'], 'integer'],
            //[['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::class, 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'                =>  'ID',
            'request_id'        => 'Request ID',
            'direct_datetime'   => 'Direct Datetime',
            'direct_from'       => 'Direct From',
            'direct_to'         => 'Direct To',
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest(): ActiveQuery
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }

    public static function create(int $request_id, int $direct_from, int $direct_to): self
    {
        $direct = new static();
        $direct->request_id            = $request_id;
        $direct->direct_datetime       = time();
        $direct->direct_from           = $direct_from;
        $direct->direct_to             = $direct_to;
        return $direct;
    }

}
