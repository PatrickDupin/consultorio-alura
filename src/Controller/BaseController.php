<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EntidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ResponseFactory;
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
    /**
     * @var ExtratorDadosRequest
     */
    private $extratorDadosRequest;

    public function __construct(
        EntityManager        $entityManager,
        ObjectRepository     $repository,
        EntidadeFactory      $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $entidade = $this->factory->criarEntidade($dadosRequest);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }

    public function buscarTodos(Request $request): Response
    {
        $filtro = $this->extratorDadosRequest->buscaDadosFiltro($request);
        $ordem = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);
        $offset = ($paginaAtual - 1) * $itensPorPagina;

        $entidadeLista = $this->repository->findBy(
            $filtro,
            $ordem,
            $paginaAtual,
            $itensPorPagina,
            $offset
        );

        $fabricaResposta = new ResponseFactory(
            true,
            $entidadeLista,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina
        );

        return $fabricaResposta->getResponse();
    }

    public function buscarUm(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $statusResposta = is_null($entidade)
            ? Response::HTTP_NO_CONTENT
            : Response::HTTP_OK;

        $fabricaResposta = new responseFactory(
            true,
            $entidade,
            $statusResposta
        );

        return $fabricaResposta->getResponse();
    }

    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($corpoRequisicao);

        try {
            $this->atualizarEntidadeExistente($entidadeExistente, $entidadeEnviada);
            $this->entityManager->flush();

            $fabrica = new ResponseFactory(
                true,
                $entidadeExistente,
                Response::HTTP_OK
            );
            return $fabrica->getResponse();

        } catch (\InvalidArgumentException $ex) {
            $fabrica = new ResponseFactory(
                false,
                'Recurso não encontrado',
                Response::HTTP_NOT_FOUND
            );
            return $fabrica->getResponse();
        }
    }

    public function remove(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    abstract public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada
    );

}