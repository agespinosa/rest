<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\TaskListRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractFOSRestController
{

    /**
     * @var TaskListRepository
     */
    private $taskListRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(TaskListRepository $taskListRepository , EntityManagerInterface $entityManager)
    {
        $this->taskListRepository = $taskListRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    public function getListsAction()
    {
        $data= $this->taskListRepository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function getListAction(int $id)
    {
        $data= $this->taskListRepository->findOneBy(['id'=>$id]);
        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="title", description="Descripcion del titulo", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postListAction(ParamFetcher $paramFetcher)
    {
        $title= $paramFetcher->get('title');
        if ($title){
            $list= new TaskList();
            $list->setTitle($title);
            $this->entityManager->persist($list);
            $this->entityManager->flush();
            return $this->view($list, Response::HTTP_OK);
        }
        return $this->view(['title'=>'this is cannot be null'], Response::HTTP_BAD_REQUEST);
    }

    public function getListsTasksAction(int $id)
    {

    }

    public function putListAction()
    {

    }

    public function backgroundListAction(int $id)
    {

    }
}
