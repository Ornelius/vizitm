<?php
namespace vizitm\services\request;



use vizitm\entities\request\Direct;
use vizitm\forms\manage\request\StaffForm;
use vizitm\repositories\DirectRepository;
use Yii;

class DirectService
{
    private ?DirectRepository $repository;

    public function __construct(DirectRepository $repository )
    {
        $this->repository = $repository;
    }
    public function createDirect(int $request_id, StaffForm $form): void
    {

            $direct = Direct::create(
                $request_id,
                Yii::$app->user->identity->getId(),
                $form->direct_to,
            );

            $this->repository->save($direct);



    }

}