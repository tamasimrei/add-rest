<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\Model\Repository;

use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\Model\Repository\AddressRepository;
use PHPUnit\Framework\TestCase;

/**
 * Integration test class for AddressRepository
 */
class AddressRepositoryTest extends TestCase
{
    /**
     * Instantiate an in memory SQLite database
     */
    protected function makeInMemoryPDO()
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * Add stupid simple dataset
     */
    protected function makeAddressDataset(\PDO $pdo)
    {
        $sql = <<< EOS
CREATE TABLE addresses (
    id INTEGER PRIMARY KEY,
    name CHAR NOT NULL,
    phone CHAR,
    street CHAR
);
INSERT INTO addresses (name, phone, street) VALUES ('foo', '123', 'Foo St');
INSERT INTO addresses (name, phone, street) VALUES ('bar', '456', 'Bar Sq');
INSERT INTO addresses (name, phone, street) VALUES ('baz', '789', 'Baz Ave');
INSERT INTO addresses (name, phone, street) VALUES ('qux', '234', 'Qux Way');
EOS;
        return $pdo->exec($sql);
    }

    /**
     * Testing AddressRepository::getById()
     */
    public function testGetById()
    {
        $pdo = $this->makeInMemoryPDO();
        $this->makeAddressDataset($pdo);

        $repository = new AddressRepository($pdo);
        $this->assertInstanceOf(AddressRepository::class, $repository);

        $address = $repository->getById(2);
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals('bar', $address->getName());
        $this->assertEquals('456', $address->getPhone());
        $this->assertEquals('Bar Sq', $address->getStreet());

        // Test with non-existent ID
        $notFoundAddress = $repository->getById(1234);
        $this->assertNull($notFoundAddress);
    }
}
