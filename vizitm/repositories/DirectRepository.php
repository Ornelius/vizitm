<?php
namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\request\Direct;
use vizitm\entities\Users;
use Yii;
use yii\db\StaleObjectException;

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

    /**
     * @throws StaleObjectException
     */
    public function update(Direct $direct): void
    {
        if(!$direct->update())
        {
            throw new RuntimeException('Ошибка назначения ответственного по Заявки №' . $direct->request_id);
        } else {
            Yii::$app->getSession()->setFlash('success', 'ПО Заявке №' . $direct->request_id . ' назначен ответчтвенным ' . Users::getFullName($direct->direct_to));
        }
    }

}