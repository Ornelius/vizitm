<?php


namespace vizitm\helpers;
use vizitm\entities\Users;
use yii\db\Query;
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
            Users::POSITION_DEGURNI_OPERATOR        => 'Дежурный оператор'
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
    public static function ListPositionUsers(): ?array
    {
        return ArrayHelper::map(Users::find()->where(['status'=>Users::STATUS_ACTIVE])->where(['position' => [1,2,3,4]])->all(), 'id', 'lastname');
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