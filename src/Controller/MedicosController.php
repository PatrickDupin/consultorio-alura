<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends BaseController
{
    /**
     * @var MedicosRepository
     */
    private $medicosRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicosRepository      $medicosRepository,
        MedicoFactory          $medicoFactory
    ) {
        parent::__construct(
            $entityManager,
            $medicosRepository,
            $medicoFactory
        );
        $this->medicosRepository = $medicosRepository;
    }

    /**
     * @param int $especialidadeId
     * @return Response
     * @Route("/especialidades/{especialidadeId}/medicos", methods={"GET"})
     */
    public function buscaPorEspecialidade(int $especialidadeId): Response
    {
        $medicos = $this->medicosRepository->findBy([
            'especialidade' => $especialidadeId
        ]);

        return new JsonResponse($medicos);
    }

    /**
     * @param Medico $entidadeExistente
     * @param Medico $entidadeEnviada
     */
    public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada
    ) {
        $entidadeExistente
            ->setCrm($entidadeEnviada->getCrm())
            ->setNome($entidadeEnviada->getNome())
            ->setEspecialidade($entidadeEnviada->getEspecialidade());
    }
}