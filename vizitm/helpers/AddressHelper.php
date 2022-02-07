<?php
namespace vizitm\helpers;

use vizitm\entities\building\Building;
use yii\helpers\ArrayHelper;

class AddressHelper
{
    public static function addressList(): array
    {

        return ArrayHelper::map(Building::find()->orderBy('address')->all(), 'id', 'address');
    }

    /**
     * @throws /Exception
     */
    public static function addressName(int $address_id): ?string
    {
        return ArrayHelper::getValue(self::addressList(), $address_id);
    }

}