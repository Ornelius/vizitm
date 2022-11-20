<?php


namespace vizitm\repositories;


use vizitm\entities\address\Buildingnumber;

class BuildingnumberRepository
{
    public function save(Buildingnumber $building): void
    {
        if(!$building->save()) {
            throw new \RuntimeException('Ошибка сохранения улицы!');
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Дом с номером: ' . $building->number . ' сохранен в БД!');
        }
    }
    public function deleteBuldingnumber(int $id)
    {
        $building = $this->findById($id);

        if(!$building->delete()){
            throw new \RuntimeException('Ошибка удаления Улицы!');
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Улица: ' . $building->number . ' удален из БД!');
        }
    }
    public function findByBuildingnumber(string $building)
    {
        return $this->getBy(['street' => $building]);
    }

    public function findById(int $id): Buildingnumber
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition)
    {
        $building = Buildingnumber::find()->andWhere($condition)->all();
        return $building ? $building : false;
    }

}