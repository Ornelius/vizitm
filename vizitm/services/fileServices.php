<?php
namespace vizitm\services\request;

use vizitm\entities\request\Request;

class fileServicesq
{
    public function createPath(Request $request): void
    {
        if(!$request->save())
        {
            throw new RuntimeException('Ошибка сохраниния Заявки!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Заявка сформирована!');
        }

    }

}