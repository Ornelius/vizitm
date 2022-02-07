<?php


namespace vizitm\helpers;


use yii\helpers\ArrayHelper;

class RequestHelper
{
    public static function typeRequestList(): array
    {
        return [
            1           => 'Оборудование',
            2           => 'Работы',
            3           => 'Житель',
            4           => 'Офис'
        ];
    }
    public static function typeRequestMnemonicList(): array
    {
        return [
            1           => '<i class="fas fa-cogs fa-lg"></i>',
            2           => '<i class="fas fa-wrench fa-lg"></i>',
            3           => '<i class="fas fa-male fa-lg"></i>',
            4           => '<i class="fas fa-user-tie fa-lg"></i>'
        ];
    }
    public static function typeRequestListName(int $type): ?string
    {
        return ArrayHelper::getValue(self::typeRequestList(), $type);
    }
    public static function typeRequestMnemonicName(int $type): ?string
    {
        return ArrayHelper::getValue(self::typeRequestMnemonicList(), $type);
    }

    public static function addressList(): array
    {
        return AddressHelper::addressList();
    }

    public static function roomList(): array
    {
        return RoomHelper::roomList();
    }
    public static function roomName($room_id): string
    {
        return RoomHelper::roomName($room_id);
    }
    public static function importanceList(): array
    {
        return [
            1           => 'Нет',
            2           => 'Важный',
        ];
    }

}