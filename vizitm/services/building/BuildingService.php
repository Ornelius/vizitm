<?php

namespace vizitm\services\building;
use vizitm\entities\building\Building;
use vizitm\helpers\StreetHelper;
use vizitm\repositories\BuildingRepository;
use vizitm\forms\manage\building\BuildingCreateForm;
use DomainException;

class BuildingService
{
    private ?BuildingRepository $repository;

    public function __construct(BuildingRepository $repository)
    {
        $this->repository = $repository;
    }
    public function createBuilding(BuildingCreateForm $form): Building
    {
        $street_name = StreetHelper::streetName($form->street_id);
        if($this->repository->findByAddress( $street_name . ' ' . $form->buildingNumber)){
            throw new DomainException('Объект недвижимости с этим адресом уже существует!');
        } else {
            $building = Building::create(
                $form->street_id,
                $form->buildingNumber,
                $street_name . ' ' . $form->buildingNumber
            );
            $this->repository->save($building);
            return $building;

        }

    }

}