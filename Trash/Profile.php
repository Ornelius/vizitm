<?php

namespace vizitm\entities;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $middlename
 * @property string|null $lastname
 * @property int|null $position
 *
 * @property Users $user
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{$profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'position'], 'integer'],
            [['name', 'middlename', 'lastname'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'            => 'ID',
            'user_id'       => 'User ID',
            'name'          => 'Имя',
            'middlename'    => 'Отчество',
            'lastname'      => 'Фамилия',
            'position'      => 'Position',
        ];
    }
}
