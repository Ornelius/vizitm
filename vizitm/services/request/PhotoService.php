<?php
namespace vizitm\services\request;



use vizitm\entities\request\Photo;
use vizitm\forms\manage\request\PhotoCreateForm;
use vizitm\repositories\PhotoRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class PhotoService
{
    public ?array $pathtoFile   = null;
    public ?array $filesName    = null;
    public ?array $pathFilesName    = null;


    private ?PhotoRepository $repository;

    public function __construct(PhotoRepository $repository )
    {
        $this->repository = $repository;
    }



    public function upload(PhotoCreateForm $form): bool
    {
        try {

            $prepath = date('Ymd') . '/' . Yii::$app->user->getId();
            $path = '/var/www/vizitm/common/uploads/' . $prepath;
            FileHelper::createDirectory($path);
            $i = 0;
            foreach ($form->imageFiles as $file) {
                $this->filesName[$i]  = date("His") . random_int(100000, 999999) . '.' . $file->extension;
                $this->pathtoFile[$i] = $path . '/' . $this->filesName[$i];
                $this->pathFilesName[$i] = $prepath . '/' . $this->filesName[$i];
                $file->saveAs($this->pathtoFile[$i]);
                $i++;
            }
            return true;
        } catch (\Exception $e) {
            //die('sdfsdfsdfsdf');
            return false;
        }
    }

    public function createPhoto(PhotoCreateForm $form, int $request_id): bool
    {
        $form->request_id = $request_id;
        $form->imageFiles = UploadedFile::getInstances($form, 'imageFiles');
        if($form->validate()){
            try {
                $this->upload($form);

            } catch (\Exception $e) {
                Yii::warning("Не сохраняется файл");
            }
        } else {
            print_r('asdasdasdasd');
            //print_r($form->imageFiles);
            die();
        }


            foreach ($this->pathFilesName as $file) {

                //print_r('sdfsdf'); die();
                $photo = Photo::create(
                    $file,
                    $request_id,
                    $file,
                    Photo::PHOTO_OF_PROBLEM,
                );
                $this->repository->save($photo);
            }

            return true;
    }

}