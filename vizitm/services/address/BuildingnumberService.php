<?php


namespace vizitm\services\address;


use vizitm\entities\address\Buildingnumber;
use vizitm\forms\manage\address\BuildingnumberCreateForm;
use vizitm\repositories\BuildingnumberRepository;

class BuildingnumberService
{
    private $repository;

    public function __construct(BuildingnumberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createBuildingnumber(BuildingnumberCreateForm $form): Buildingnumber
    {
            $bnumber = Buildingnumber::create(
                $form->number,
                $form->street_id
            );
            $this->repository->save($bnumber);
            return $bnumber;
    }
}