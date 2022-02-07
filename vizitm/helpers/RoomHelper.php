<?php


namespace vizitm\helpers;


use Exception;
use yii\helpers\ArrayHelper;

class RoomHelper
{
    public static function roomList(): array
    {
        return [
            1 => 'Котельная',
            2 => 'Тепловой пункт',
            3 => 'Бойлерная',
            4 => 'Подвал',
            5 => 'Тех. этаж',
            6 => 'МОП',
            7 => 'Эл. щитовая',
            8 => 'Паркинг',
            9 => 'Ж. помещение',
            10 => 'Н. помещение',
            11 => 'Консьержная',
            12 => '1-й этаж'
        ];
    }

    /**
     * @throws Exception
     */
    public static function roomName(int $room_id): ?string
    {
        return ArrayHelper::getValue(self::roomList(), $room_id);
    }

}