<?php


namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\request\Request;
use Yii;

class RequestRepository
{
    public function save(Request $request): void
    {
        if(!$request->save())
        {
            throw new RuntimeException('Ошибка сохраниния Заявки!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Новая заявка сформирована!');
        }

    }
    public function update(Request $request): void
    {
        if(!$request->update())
        {
            throw new RuntimeException('Ошибка обновления Заявки!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Заявка №' . $request->id);
        }
    }

    public function get(int $id): Request
    {
        return $this->getBy(['id' => $id]);
    }

    private function getBy(array $condition)
    {
        $request = Request::find()->andWhere($condition)->limit(1)->one();
        return $request ? $request : false;
    }


}