<?php


namespace vizitm\helpers;
use vizitm\entities\slaves\Slaves;
use vizitm\entities\Users;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    const POSITION = 1;
    const STATUS   = 2;

    public static function positionList(): array
    {
        return [
            Users::POSITION_ADMINISTRATOR           => 'Администратор',
            Users::POSITION_TEPLOTEHNIK             => 'Теплотехник',
            Users::POSITION_INGENER                 => 'Инженер',
            Users::POSITION_GL_INGENER              => 'Гл.Инженер',
            Users::POSITION_KIP                     => 'Инженер КИПиА',
            Users::POSITION_UCHETCHIK               => 'Учетчик',
            Users::POSITION_DEGURNI_OPERATOR        => 'Дежурный оператор',
            Users::POSITION_POMOSHNIK_INGENERA      => 'Помошник инжнера',
            Users::POSITION_POMOSHNIK_POMOSHNIKA      => 'Помошник помошника инжнера'
        ];
    }

    public static function statusList(): array
    {
        return [
          Users::STATUS_INACTIVE    => 'Inactive',
          Users::STATUS_ACTIVE      => 'Active',
        ];
    }
    public static function ListAllUsers(): ?array
    {
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE])->all(), 'id', 'lastname');
    }
    public static function ListAllUsersExeptOne(int $id=null): ?array
    {
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE, ])
            ->andWhere(['not', ['id' => $id]])
            ->andWhere(['not', ['position' => Users::POSITION_ADMINISTRATOR]])->all(),
        'id', 'lastname');
    }
    public static function ListAllUsersExceptSome(int $id): ?array
    {
        if(Users::findUserByID(Yii::$app->user->getId())->position !== Users::POSITION_GL_INGENER)
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE, ])
            ->andWhere(['not', ['id' => $id]])
            ->andWhere(['not', ['position' => Users::POSITION_INGENER]])
            ->andWhere(['not', ['position' => Users::POSITION_DEGURNI_OPERATOR]])
            ->andWhere(['not', ['position' => Users::POSITION_GL_INGENER]])
            ->andWhere(['not', ['position' => Users::POSITION_ADMINISTRATOR]])->all(),
            'id', 'lastname');
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE, ])
            ->andWhere(['not', ['id' => $id]])
            ->andWhere(['position' => Users::POSITION_INGENER])->all(),
            'id', 'lastname');
    }
    public static function ListSlavesUsers(int $id_master): ?array
    {
        $slaves = Slaves::findSlavesByMasterID($id_master);

        $data = ArrayHelper::toArray($slaves, [
            'vizitm\entities\slaves\Slaves' => [
                'slave_id',
                'lastname' => function ($slaves) {
                    return Users::findUserByID($slaves['slave_id'])->lastname;
                },
            ],
        ]);

        return ArrayHelper::merge(ArrayHelper::map($data,'slave_id', 'lastname'), [$id_master => 'Взять себе']);
    }



    public static function ListPositionUsers(): ?array
    {
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE])->where(['position' => [1,2,3,4]])->all(), 'id', 'lastname');
    }
    public static function ListPositionUsersNotActive(): ?array
    {
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE])->where([
            'position' => [
                Users::POSITION_TEPLOTEHNIK,
                Users::POSITION_INGENER,
                Users::POSITION_GL_INGENER,
                Users::POSITION_KIP,
                Users::POSITION_POMOSHNIK_INGENERA,
            ]])->all(), 'id', 'lastname');
    }
    public static function ListName($key, int $stOrPos): ?string
    {
        switch ($stOrPos){
            case self::POSITION:
                return ArrayHelper::getValue(self::positionList(), $key);
            case self::STATUS:
                return ArrayHelper::getValue(self::statusList(), $key);
        }
        return false;

    }
    public static function statusLabel($status): string
    {
        switch ($status) {
            case Users::STATUS_INACTIVE:
                $class = 'badge badge-pill badge-primary';
                break;
            case Users::STATUS_ACTIVE:
                $class = 'badge badge-pill badge-success';
                break;
            default:
                $class = 'badge badge-pill badge-primary';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function positionName($position): ?string
    {
        return ArrayHelper::getValue(self::positionList(), $position);
    }
    public static function positionLabel($position): string
    {
        switch ($position) {
            case 1:
                $class = 'badge badge-pill badge-primary';
                break;
            case 2:
                $class = 'badge badge-pill badge-success';
                break;
            case 3:
                $class = 'badge badge-pill badge-danger';
                break;

            default:
                $class = 'badge badge-pill badge-primary';
        }
        return Html::tag('span', ArrayHelper::getValue(self::positionList(), $position), [
            'class' => $class,
        ]);
    }



}