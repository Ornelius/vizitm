<?php


namespace vizitm\repositories;
use RuntimeException;
use vizitm\entities\request\Video;
use Yii;

class VideoRepository
{
    //private ?string $path;
    public function save(Video $video): void
    {

        if(!$video->save())
        {
            throw new RuntimeException('Ошибка сохраниния Видеофайла!');
        } else {
            Yii::$app->getSession()->setFlash('success', 'Видеоматериал сохранен!');
        }

    }



}