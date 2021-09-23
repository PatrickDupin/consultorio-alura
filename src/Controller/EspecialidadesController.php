<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EspecialidadeRepository
     */
    private $especialidadeRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param EspecialidadeRepository $especialidadeRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
    }

    /**
     * @Route("/especialidades", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function nova(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosEmJson = json_decode($dadosRequest);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosEmJson->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @return Response
     * @Route("/especialidades", methods={"GET"})
     */
    public function buscarTodas(): Response
    {
        $especialidadesList = $this->especialidadeRepository->findAll();

        return new JsonResponse($especialidadesList);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/especialidades/{id}", methods={"GET"})
     */
    public function buscarUma(int $id): Response
    {
        $especialidade = $this->especialidadeRepository->find($id);
        $codigoRetorno = is_null($especialidade) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse($especialidade, $codigoRetorno);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/especialidades/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosEmJson = json_decode($dadosRequest);

        $especialidade = $this->especialidadeRepository->find($id);
        $especialidade
            ->setDescricao($dadosEmJson->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $especialidade = $this->entityManager->getReference(Especialidade::class, $id);

        $this->entityManager->remove($especialidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
