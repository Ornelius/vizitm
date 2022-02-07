<?php

namespace backend\entities;

use Yii;

/**
 * This is the model class for table "{{%roles}}".
 *
 * @property int $id
 * @property string $role
 * @property int $role_id
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'role_id'], 'required'],
            [['role_id'], 'integer'],
            [['role'], 'string', 'max' => 255],
            [['role'], 'unique'],
            [['role_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Роль пользователя',
            'role_id' => 'Идентификатор роли',
        ];
    }
}
