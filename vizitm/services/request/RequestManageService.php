<?php
namespace vizitm\services\request;
use DomainException;
use http\Exception\RuntimeException;
use vizitm\entities\building\Building;
use vizitm\entities\request\Photo;
use vizitm\entities\request\Request;
use vizitm\entities\Users;
use vizitm\forms\manage\request\RequestCreateForm;
use vizitm\forms\manage\request\RequestEditForm;
use vizitm\forms\manage\request\RequestUpdateForm;
use vizitm\forms\manage\request\StaffForm;

use vizitm\repositories\CommentRepository;
use vizitm\repositories\PhotoRepository;
use vizitm\repositories\RequestRepository;
use vizitm\repositories\VideoRepository;
use vizitm\services\comments\CommentService;
use Yii;
use yii\db\StaleObjectException;

class RequestManageService
{
    private ?RequestRepository      $repository;
    private ?PhotoRepository        $photoRepository;
    private ?VideoRepository        $videoRepository;

    public function __construct(RequestRepository $repository, PhotoRepository $photoRepository, VideoRepository  $videoRepository)
    {
        $this->repository = $repository;
        $this->photoRepository = $photoRepository;
        $this->videoRepository = $videoRepository;
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


    public function edit(RequestEditForm $form, int $id): bool
    {
        $request = $this->repository->get($id);
        $request->edit($form);
        //print_r($request ); die();
        $this->repository->save($request);
        return true;
    }

    /**
     * @throws StaleObjectException
     */
    public function requestDone(RequestUpdateForm $form, int $id): bool
    {
        $request = $this->repository->get($id);
        $request->done($form->done_description);
        $this->repository->update($request);
        $this->saveRequestPhoto($form->photo->files, $request,Photo::PHOTO_OF_PROBLEM_DONE);
        return true;
    }

    /**
     * @throws StaleObjectException
     */
    public function requestWork(int $id, StaffForm $staff):bool
    {

        $request = $this->repository->get($id);
        $request->work($staff->direct_to);
        $this->repository->update($request);
        //$this->commentRepository->save($staff->comets);
        //print_r($staff->direct_to); die();
        //if(!empty(Users::findEmailByID($staff->direct_to)))
        if (!Yii::$app->mailer->compose()
            ->setFrom('vizitm.samara@gmail.com')
            ->setTo(Users::findEmailByID($staff->direct_to))
            ->setSubject('Вам направлена заявка: ' . Building::getAddressByID($request->building_id))
            ->setTextBody('Внимание')
            ->setHtmlBody('<b>' . $request->description . '</b>')
            ->send())
        {
            throw new RuntimeException('Письмо не отправилось!');

        }

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
                ///////print_r('$photo'); die();
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