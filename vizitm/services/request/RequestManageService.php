<?php
namespace vizitm\services\request;
use DomainException;
use vizitm\entities\request\Photo;
use vizitm\entities\request\Request;
use vizitm\entities\building\Building;
use vizitm\entities\Users;
use vizitm\forms\manage\request\RequestCreateForm;
use vizitm\forms\manage\request\RequestUpdateForm;
use vizitm\forms\manage\request\StaffForm;
use vizitm\repositories\PhotoRepository;
use vizitm\repositories\RequestRepository;
use Yii;

class RequestManageService
{
    private ?RequestRepository      $repository;
    private ?PhotoRepository        $photoRepository;

    public function __construct(RequestRepository $repository, PhotoRepository $photoRepository)
    {
        $this->repository = $repository;
        $this->photoRepository = $photoRepository;
    }

    public function createRequest(RequestCreateForm $form): Request
    {

        if (!$form->building_id) {
            throw new DomainException('Выберите адрес здания!');
        } elseif (!$form->description) {
            throw new DomainException('Опишите проблему!');
        } elseif (!$form->type) {
            throw new DomainException('Необходимо указать тип заявки!');
        } elseif (!$form->room) {
            throw new DomainException('Необходимо указать тип помещения!');
        } else{

            $request = Request::create(
                $form->building_id,
                $form->description,
                $form->type,
                $form->room,
                $form->type_of_work,
                //$form->importance,
                $form->due_date
            );

            $this->repository->save($request);

            $this->saveRequestPhoto($form->photo->files, $request, Photo::PHOTO_OF_PROBLEM);


            return $request;
        }


    }

    public function requestDone(RequestUpdateForm $form, int $id): bool
    {
        $request = $this->repository->get($id);
        $request->done($form->done_description);
        $this->repository->update($request);
        //print_r('asdfasd'); die();
        $this->saveRequestPhoto($form->photo->files, $request,Photo::PHOTO_OF_PROBLEM_DONE);
        return true;
    }
    public function requestWork(int $id, StaffForm $staff):bool
    {
        $request = $this->repository->get($id);
        $request->work($staff->direct_to);
        $this->repository->update($request);
        Yii::$app->mailer->compose()
            ->setFrom('vizitm.samara@gmail.com')
            ->setTo(Users::findEmailByID($staff->direct_to))
            ->setSubject('Вам направлена заявка: ' . Building::getAddressByID($request->building_id))
            ->setTextBody('Внимание')
            ->setHtmlBody('<b>' . $request->description . '</b>')
            ->send();
        return true;
    }

    private function saveRequestPhoto(array $files, Request $request, $typeOfFile)
    {


        for ($i=0; $i<=count($files)-1; $i++)
        {
            if(preg_match("/\bvideo\b/i", $files[$i]->type) || preg_match("/\bapplication\b/i",$files[$i]->type)){
                $var = $files[$i];
                unset($files[$i]);
                array_push($files, $var);
            }

        }

        foreach ($files as $file) {
            if (preg_match("/\bimage\b/i", $file->type)) {

                $photo = $request->addPhoto($file, $request->id, $typeOfFile, Photo::TYPE_IMG);
                //print_r($photo); die();
                $this->photoRepository->save($photo);

            } elseif (preg_match("/\bvideo\b/i", $file->type)) {
                $photo = $request->addPhoto($file, $request->id, $typeOfFile, Photo::TYPE_VIDEO);
                $photo->setThumbsOnSave(false);
                $this->photoRepository->save($photo);
            } elseif (preg_match("/\bapplication\b/i", $file->type)) {
                $photo = $request->addPhoto($file, $request->id, $typeOfFile, Photo::TYPE_PDF);
                $photo->setThumbsOnSave(false);
                $this->photoRepository->save($photo);
            }

        }
    }

}