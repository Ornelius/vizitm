<?php


namespace vizitm\repositories;


use Imagine\Exception\RuntimeException;
use vizitm\entities\comments\Comments;
use vizitm\entities\Users;
use Yii;
use yii\db\StaleObjectException;

class CommentRepository
{
    public function save(Comments $comment): void
    {

        if(!$comment->save())
        {
            throw new RuntimeException('Ошибка сохраниния комментария!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Комментарий №' . $comment->id . ' оставленный пользователем ' . Users::getFullName($comment->user_id));
        }

    }

    /**
     * @throws StaleObjectException
     */
    public function update(Comments $comment): void
    {
        if(!$comment->update())
        {
            throw new RuntimeException('Ошибка коменария' . $comment->id);
        } else {
            Yii::$app->getSession()->setFlash('success', 'Комментарий №' . $comment->id . ' исправил пользователь ' . Users::getFullName($comment->user_id));
        }
    }

}