<?php


namespace vizitm\helpers;


use Exception;
use vizitm\entities\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PositionHelper
{
    public static function positionList(): array
    {
       return UserHelper::positionList();
    }

    /**
     * @throws Exception
     */
    public static function positionName($position): ?string
    {
       return ArrayHelper::getValue(self::positionList(), $position);
    }

    /**
     * @throws Exception
     */
    public static function statusLabel($position): string
    {
        switch ($position) {
            case 1:
                $class = 'label label-default';
                break;
            case 2:
                $class = 'label label-success';
                break;
            case 3:
                $class = 'label label-error';
                break;

            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::positionList(), $position), [
            'class' => $class,
        ]);
    }

}