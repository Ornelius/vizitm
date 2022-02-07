<?php
namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\request\Direct;
use vizitm\entities\Users;
use Yii;

class DirectRepository
{
    public function save(Direct $direct): void
    {

        if(!$direct->save())
        {
            throw new RuntimeException('Ошибка сохраниния списка ответственного!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'ПО Заявке №' . $direct->request_id . ' назначен ответчтвенным ' . Users::getFullName($direct->direct_to));
        }

    }

}