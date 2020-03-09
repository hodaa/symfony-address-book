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

    public function testShow()
    {
        $this->client->request('get', '/edit_address_book/1');

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

}
