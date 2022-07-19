<?php

namespace vizitm\entities\street;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%street}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property string $name
 */
class Street extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%street}}';
    }

    public static function create(string $name): Street
    {
        $street = new static();
        $street->created_at     = time();
        $street->created_by     = Yii::$app->user->id;
        $street->name           = $name;
        return $street;
    }

}
