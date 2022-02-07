<?php


namespace vizitm\services\address;


use vizitm\entities\address\Street;

class AddressService
{
    private $address;

    public function __construct(Street $street, string $number)
    {
        $this->address = $street->street . ', ' . $number;

    }

    public function createStreet(StreetCreateForm $form): Street
    {
        if($this->repository->findByStreet($form->street)){
            throw new \DomainException('Улица уже существует');
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
            throw new \DomainException('Такая улица уже существует!');
        }
        return $street;
    }




}