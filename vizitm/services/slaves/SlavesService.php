<?php
namespace vizitm\services\slaves;

use vizitm\entities\slaves\Slaves;
use vizitm\forms\slaves\SlavesForm;
use vizitm\repositories\SlavesRepository;
use yii\db\StaleObjectException;

class SlavesServices
{
    private SlavesRepository $repository;

    public function __construct(SlavesRepository $repository)
    {
        $this->repository = $repository;

    }

    public function create(SlavesForm $form): Slaves
    {
        $slave = Slaves::create(
            $form->master_id,
            $form->slave_id
        );
        $this->repository->save($slave);
        return $slave;
    }

    /**
     * @throws StaleObjectException
     */
    public function remove($id) : void{
        $slave = $this->repository->findById($id);
        $this->repository->deleteSlaves($slave);
    }

}