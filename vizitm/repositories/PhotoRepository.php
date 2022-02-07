<?php


namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\request\Photo;
use Yii;

class PhotoRepository
{
    public function save(Photo $photo): void
    {
        //print_r($photo); die();

        if(!$photo->save())
        {
            throw new RuntimeException('Ошибка сохраниния Фотографий!');
        } else {
            $photo->updateAttributes(['path' => $photo->getImageFileUrl('path')]);
            //Yii::$app->getSession()->setFlash('success', 'Фото сохранены!');
        }

    }



}