<?php

namespace AppBundle\Controller;

use AppBundle\Service\RequestFormatterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use AppBundle\Repository\AddressBookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\AddressBook;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use AppBundle\Service\PaginationService;
use AppBundle\Service\ValidationService;

class AddressBookController extends AbstractController
{
    /**
     * @var AddressBookRepository
     */
    private $addressBookRepository;


    /**
     * AddressBookController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->addressBookRepository = $entityManager->getRepository(AddressBook::class);
    }

    /**
     * @Route("/", name="address_book")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(Request $request, PaginationService $pagination): Response
    {
        $currentPage = $request->query->getInt('page') ?: 1;
        $query   =   $this->addressBookRepository->listAll();
        $results = $pagination->paginate($query, $currentPage, 5);


        return $this->render('addressBook/index.html.twig', [
            'addresses' => $results,
            'lastPage' => $pagination->lastPage($results),
            'total' => $pagination->total($results),
            'thisPage' => $currentPage,
            'maxPages' => $pagination->getMaxPages($results)

        ]);
    }

    /**
     * @Route("/add_address_book", name="add_address_book")
     */
    public function addAction(): Response
    {
        return $this->render('addressBook/add.html.twig');
    }

    /**
     * @Route("/store_address_book", name="store_address_book",methods="POST")
     * @param Request $request
     * @param ValidationService $validator
     * @return Response
     */
    public function storeAction(Request $request, RequestFormatterService $formatterService, ValidationService $validator): Response
    {
        if ($this->isCsrfTokenValid('add_address', $request->request->get('token'))) {
            $inputs = $formatterService->format($request);

            $errors = $validator->validateInput($inputs);

            if (count($errors) > 0) {
                foreach ($errors as $key => $error) {
                    $this->addFlash($key, $error);
                }
                return $this->render('addressBook/add.html.twig', [
                    'errors' => $errors,
                ]);
            } else {
                $this->addFlash('success', 'Address Book Created Successfully!');
            }

            $this->addressBookRepository->store($inputs);
            return $this->redirectToRoute('address_book');
        }
        $this->addFlash('notice', 'Operation not allowed');
        return $this->redirectToRoute('address_book');
    }

    /**
     * @Route("/edit_address_book/{id}", name="edit_address_book",methods="get")
     * @param $productId
     * @return Response
     */

    public function showAction($id): Response
    {
        $book = $this->addressBookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No Address book found for id ' . $id
            );
        }

        return $this->render('addressBook/edit.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/update_address_book/{id}", name="update_address_book",methods="POST")
     * @param Request $request
     * @param $id
     * @param ValidationService $validator
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateAction(Request $request, RequestFormatterService $formatterService, $id, ValidationService $validator) :Response
    {
        if ($this->isCsrfTokenValid('edit_address', $request->request->get('token'))) {
            $inputs = $formatterService->format($request);
            $errors = $validator->validateInput($inputs);

            $this->addressBookRepository->update($id, $inputs);
            if (count($errors) > 0) {
                foreach ($errors as $key => $error) {
                    $this->addFlash($key, $error);
                }
                return $this->render('addressBook/edit.html.twig', [
                    'errors' => $errors,
                    'book' => $this->addressBookRepository->find($id)
                ]);
            } else {
                $this->addFlash('success', 'Address Book Updated Successfully!');
            }

            return $this->redirectToRoute('address_book');
        }
        $this->addFlash('notice', 'Operation not allowed');
        return $this->redirectToRoute('address_book');
    }

    /**
     * @Route("/delete_address_book/{id}", name="delete_address_book",methods="DELETE")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id): Response
    {
        if (!$this->addressBookRepository->find($id)) {
            throw $this->createNotFoundException(
                'No Address book found for id ' . $id
            );
        }
        $this->addFlash('success', 'Item Deleted Successfully!');
        $this->addressBookRepository->remove($id);
        return $this->redirectToRoute('address_book');
    }
}
