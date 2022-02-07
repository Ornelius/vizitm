<?php
namespace vizitm\services\address;
use DomainException;
use vizitm\repositories\StreetRepository ;
use vizitm\entities\address\Street;
use vizitm\forms\manage\address\StreetCreateForm;

class StreetService
{
    private StreetRepository $repository;

    public function __construct(StreetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createStreet(StreetCreateForm $form): Street
    {
        if($this->repository->findByStreet($form->street)){
            throw new DomainException('Улица уже существует');
        } else {
            $street = Street::create(
                $form->street
            );
            $this->repository->save($street);
            return $street;
        }

    }
    public function getStreetName(StreetCreateForm $form)
    {
        if ($street = $this->repository->findByStreet($form->street)) {
            throw new DomainException('Такая улица уже существует!');
        }
        return $street;
    }

}