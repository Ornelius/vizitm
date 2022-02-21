<?php


namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\Users;
use Yii;
use yii\db\StaleObjectException;

class UserRepository
{

    public function save(Users $user): void
    {
        if(!$user->save()) {

            throw new RuntimeException('Ошибка сохранения пользователя');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Пользователь: ' . $user->username . ' сохранен в БД!');
        }
    }

    /**
     * @throws StaleObjectException
     */
    public function deleteUsers(int $id)
    {
        $user = $this->findById($id);

        if(!$user->delete()){
            throw new RuntimeException('Ошибка удаления пользователя!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Пользователь: ' . $user->username . ' удален из БД!');
        }
    }
    public function findByUsername(string $username)
    {
        return $this->getBy(['username' => $username]);
    }
    public function findByEmail(string $email)
    {
        return $this->getBy(['email' => $email]);
    }

    public function get(int $id): Users
    {
        return $this->getBy(['id' => $id]);
    }

    public function findById(int $id): Users
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition)
    {
        $user = Users::find()->andWhere($condition)->limit(1)->one();
        return $user ?: false;
    }




}