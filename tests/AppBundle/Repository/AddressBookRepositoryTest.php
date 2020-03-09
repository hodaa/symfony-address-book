<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\AddressBook;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressBookRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByCategoryName()
    {
        $products = $this->entityManager
            ->getRepository(AddressBook::class)
            ->findAll();

        $this->assertCount(0, $products);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}