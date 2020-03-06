<?php


namespace Tests\AppBundle\Controller;

use AppBundle\Entity\AddressBook;
use AppBundle\Repository\AddressBookRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressBookControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();

        $employeeRepository = $this->createMock(AddressBookRepository::class);
//        $employeeRepository->store();

//         $repo = new AddressBookRepository($em, Mapping\ClassMetadata $class);
         $employeeRepository->store(['last_name'=>'hussin']);

//        $addressBook = new AddressBook();

//        $addressBook->setFirstName("hoda");
//        $addressBook->setLastName("hussin");
//        $addressBook->setCountry("Egypt");
//        $addressBook->setStreet("Sammnoud 30");
//        $addressBook->setCity("Cairo");
//        $addressBook->setBirthday('1988-01-02');
//        $addressBook->setEmail("hoda.hussin@gmail.com");

    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Address Book', $crawler->filter('#container h2')->text());
    }

    public function testAdd()
    {
        $crawler = $this->client->request('GET', '/add_address_book');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Adding new address book', $crawler->filter('#container h2')->text());
    }

    public function testStore()
    {
        $this->client->request('post', '/store_address_book');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
    }
    public function testShow()
    {
        $this->client->request('get', '/edit_address_book/1');

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdate()
    {
        $this->client->request('PUT', '/update_address_book/2');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    public function testDelete()
    {
        $resp= $this->client->request('DELETE', '/delete_address_book/1');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
    }
}
