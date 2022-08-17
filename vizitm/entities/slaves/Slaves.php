<?php

namespace vizitm\entities\slaves;

use vizitm\entities\Users;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{%slave}}".
 *
 * @property int $id
 * @property int $master_id
 * @property int $slave_id
 * @property-read ActiveQuery $users
 *
 */
class Slaves extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%slave}}';
    }

    public function attributeLabels(): array
    {
        return [
            'master_id'     => 'Начальник',
            'slave_id'      => 'Подчиненный',
        ];
    }

    public static function create(int $master_id, int $slave_id): self
    {
        $slaves = new static();
        $slaves->master_id          = $master_id;
        $slaves->slave_id           = $slave_id;
        return $slaves;
    }

    public function edit($master_id, $slaves_id): void
    {
        $this->master_id    = $master_id;
        $this->slave_id     = $slaves_id;
    }

    public static function findSlavesID(int $master_id, int $slave_id): ?Slaves
    {
        return self::findOne(['master_id' => $master_id, 'slave_id' => $slave_id]);
    }
    public static function findSlavesByMasterID(int $master_id): ?array
    {
        return self::findAll(['master_id' => $master_id]);
    }

    public static function haveSlaves(int $userID): bool
    {
        return !empty(self::findSlavesByMasterID($userID));
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'master_id']);
    }
}