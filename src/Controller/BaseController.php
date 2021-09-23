<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EntidadeFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var ObjectRepository
     */
    protected $repository;
    /**
     * @var EntidadeFactory
     */
    protected $factory;

    public function __construct(
        EntityManager    $entityManager,
        ObjectRepository $repository,
        EntidadeFactory  $factory
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $entidade = $this->factory->criarEntidade($dadosRequest);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }

    public function buscarTodos(): Response
    {
        $entidadeLista = $this->repository->findAll();

        return new JsonResponse($entidadeLista);
    }

    public function buscarUm(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $codigoRetorno = is_null($entidade) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse($entidade, $codigoRetorno);
    }

    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($corpoRequisicao);

        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntidadeExistente($entidadeExistente, $entidadeEnviada);

        $this->entityManager->flush();

        return new JsonResponse($entidadeExistente);
    }

    public function remove(int $id): Response
    {
        $entidade = $this
            ->entityManager
            ->getReference(Especialidade::class, $id);

        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    abstract public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada
    );

}