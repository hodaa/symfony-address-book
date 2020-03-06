<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AddressBook;
use AppBundle\Service\FileUploader;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AddressBookRepository extends EntityRepository
{

    public function store($inputs)
    {
        $address_book = new AddressBook();
        $this->setData($address_book, $inputs);

        if ($inputs['picture'] !==null) {
            $root = realpath(__DIR__. '/../../../');
            $upload = new FileUploader($root . '/web/uploads/images');
            $pictureName = $upload->upload($inputs['picture']);
            $address_book->setPicture($pictureName);
        }


        $this->_em->persist($address_book);
        $this->_em->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function listAll()
    {
        $developers = $this->_em->getRepository(AddressBook::class);

        // build the query for the doctrine paginator
        $query = $developers->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @param $data
     * @param $file
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($id, $data)
    {
        $address_book = $this->find($id);
        $this->setData($address_book, $data);

        if ($data['picture'] !== null) {
            $root = realpath(__DIR__. '/../../../');
            $upload = new FileUploader($root . '/web/uploads/images');
            $pictureName = $upload->upload($data['picture']);
            $address_book->setPicture($pictureName);
        }


        $this->_em->persist($address_book);
        $this->_em->flush();
    }

    /**
     * @param $address_book
     * @param $data
     */
    public function setData($address_book, $data)
    {
        $address_book->setFirstName($data['first_name']);
        $address_book->setLastName($data['last_name']);
        $address_book->setStreet($data['street']);
        $address_book->setZip($data['zip']);
        $address_book->setCity($data['city']);
        $address_book->setCountry($data['country']);
        $address_book->setPhoneNumber($data['phone_number']);
        $address_book->setEmail($data['email']);
        $address_book->setBirthday($data['birthday']);
    }
    public function remove($id)
    {
        $addressBook = $this->find($id);
        $this->_em->remove($addressBook);
        $this->_em->flush();
    }
}
