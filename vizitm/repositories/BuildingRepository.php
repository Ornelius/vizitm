<?php


namespace vizitm\repositories;


use http\Exception\RuntimeException;
use vizitm\entities\building\Building;

class BuildingRepository
{
    public function save(Building $building): void
    {
        if(!$building->save())
        {
            throw new \RuntimeException('Ошибка сохраниния объекта недвижимости по адресу:' . $building->address);
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Объект недвижимости по адресу: ' . $building->address . ' сохранен в БД!');
        }

    }

    public function deleteBuilding(int $id)
    {
        $building = $this->findById($id);
        if(!$building->delete())
        {
            throw new \RuntimeException('Ошибка удаления объекта недвижимости по адресу: ' . $building->address);
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Объект недвижимости по адресу: ' . $building->address . ' удален из БД!');
        }
    }

    public function findByAddress(string $address)
    {
        return $this->getBy(['address' => $address]);

    }
    public function findById(int $id)
    {
        return $this->getBy(['id' => $id]);

    }
    private function getBy(array $condition)
    {
        $building = Building::find()->andWhere($condition)->limit(1)->one();
        return $building ? $building : false;

    }

}