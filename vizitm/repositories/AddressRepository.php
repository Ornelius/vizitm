<?php


namespace vizitm\repositories;


class AddressRepository
{

    public function save(Street $street): void
    {
        if(!$street->save()) {
            throw new \RuntimeException('Ошибка сохранения улицы!');
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Улица: ' . $street->street . ' сохранен в БД!');
        }
    }
    public function deleteStreet(int $id)
    {
        $street = $this->findById($id);

        if(!$street->delete()){
            throw new \RuntimeException('Ошибка удаления Улицы!');
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Улица: ' . $street->street . ' удален из БД!');
        }
    }
    public function findByStreet(string $street)
    {
        return $this->getBy(['street' => $street]);
    }

    public function findById(int $id): Street
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition)
    {
        $street = Street::find()->andWhere($condition)->limit(1)->one();
        return $street ? $street : false;
    }



}