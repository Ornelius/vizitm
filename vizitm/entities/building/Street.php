<?php

namespace vizitm\entities\building;

use Yii;

/**
 * This is the model class for table "{{%street}}".
 *
 * @property int $id
 * @property string $street
 *
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%street}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules():  array
    {
        return [
            [['street'], 'required'],
            [['street'], 'string', 'max' => 255],
            [['street'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'street' => 'Street',
        ];
    }
}
