<?php


namespace vizitm\helpers;

use vizitm\entities\address\Street;
use yii\helpers\ArrayHelper;

class StreetHelper
{
    public static function streetList(): array
    {
        return ArrayHelper::map(Street::find()->all(), 'id', 'street');
    }

    /**
     * @throws /Exception
     */
    public static function streetName(int $street_id): ?string
    {
        return ArrayHelper::getValue(self::streetList(), $street_id);
    }

}