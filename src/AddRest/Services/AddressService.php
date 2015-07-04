<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Services;

use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\Model\Repository\AddressRepository;

/**
 * Serving different Address handling purposes
 */
class AddressService
{
    /**
     * @var AddressRepository
     */
    protected $repository;

    /**
     * This service depends on an instance of the repository for addresses
     *
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Convert an Address entity into an assoc array
     *
     * @param Address $address
     * @return array
     */
    public function convertEntityToArray(Address $address)
    {
        return [
            "name" => $address->getName(),
            "phone" => $address->getPhone(),
            "street" => $address->getStreet()
        ];
    }

    /**
     * Get one Address entity by its ID
     *
     * @param int $addressId
     * @return Address
     */
    public function getEntityById($addressId)
    {
        return $this->repository->getById($addressId);
    }
}
