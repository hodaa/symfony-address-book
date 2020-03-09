<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AddressBook;
use AppBundle\Service\FileUploader;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AddressBookRepository extends EntityRepository
{
    /**
     * @param $inputs
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store($inputs)
    {

        $this->_em->persist($inputs);
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($id)
    {
        $addressBook = $this->find($id);
        $this->_em->remove($addressBook);
        $this->_em->flush();
    }
}
