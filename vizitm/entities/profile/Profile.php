<?php

namespace vizitm\entities\profile;

use Yii;

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
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'position' => 'Position',
        ];
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
