<?php

/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */

namespace Imrei\AddRest\Model\Repository;

use Imrei\AddRest\Model\Entity\Address;

/**
 * Simple repository class using a PDO instance and SQL-92 to load/save data
 */
class AddressRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * This repository depends on an existing \PDO instance
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get one Address entity by its ID
     *
     * @param int $addressId
     * @return Address
     */
    public function getById($addressId)
    {
        $statement = $this->pdo->prepare(
            'SELECT id, name, phone, street FROM addresses WHERE id = ?'
        );
        // No need to sanitize $id, PDO does it
        $statement->execute(array($addressId));

        // Fetch directly into an Entity object
        $statement->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            Address::class
        );
        $address = $statement->fetch();

        // Address not found
        if (empty($address)) {
            return null;
        }

        return $address;
    }
}
