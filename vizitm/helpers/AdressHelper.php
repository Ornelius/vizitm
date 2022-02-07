<?php
namespace vizitm\helpers;

use vizitm\entities\building\Building;
use yii\helpers\ArrayHelper;

class AddressHelper
{
    public static function streetList(): array
    {
        return ArrayHelper::map(Building::find()->all(), 'id', 'address');
    }

    /**
     * @throws /Exception
     */
    public static function streetName(int $street_id): ?string
    {
        return ArrayHelper::getValue(self::streetList(), $street_id);
    }

}