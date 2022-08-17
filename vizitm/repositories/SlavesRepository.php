<?php


namespace vizitm\repositories;
use vizitm\entities\slaves\Slaves;
use vizitm\entities\Users;
use yii\db\StaleObjectException;


class SlavesRepository
{
    public function save(Slaves $slaves): void
    {
        if(!Slaves::findSlavesID($slaves->master_id, $slaves->slave_id)) {
            if(!$slaves->save()) {
                throw new \RuntimeException('Ошибка сохранения в репозитории Slaves!');
            } else {
                \Yii::$app->getSession()->setFlash('success', 'Подчиненный назначен!');
            }
            return;
        }
        $user = Users::findUserByID($slaves->slave_id);
        \Yii::$app->getSession()->setFlash('error', 'Содрудник ' . $user->lastname . ' ' . $user->name . ' уже является вашим подчиненным!');


    }

    /**
     * @throws StaleObjectException
     */
    public function deleteSlaves(Slaves $slaves)
    {

        if(!$slaves->delete()){
            throw new \RuntimeException('Ошибка удаления Подчиненного!');
        } else {
            \Yii::$app->getSession()->setFlash('success', 'Подчиненный: ' . Users::getFullName($slaves->slave_id) . ' удален из БД!');
        }
    }

    public function findById(int $id): Slaves
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition)
    {
        $slaves = Slaves::find()->andWhere($condition)->limit(1)->one();
        return $slaves ?: false;
    }

}