<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
use App\Helper\ExtratorDadosRequest;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MedicosController extends BaseController
{
    /**
     * @var MedicoFactory
     */
    private $medicoFactory;
    /**
     * @var MedicosRepository
     */
    private $medicosRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicosRepository      $medicosRepository,
        MedicoFactory          $medicoFactory,
        ExtratorDadosRequest   $extratorDadosRequest
    )
    {
        parent::__construct(
            $entityManager,
            $medicosRepository,
            $medicoFactory,
            $extratorDadosRequest
        );
        $this->medicoFactory = $medicoFactory;
        $this->medicosRepository = $medicosRepository;
    }

    /**
     * @param int $especialidadeId
     * @return Response
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
        /** @var Medico $entidadeExistente */
        $entidadeExistente = $this->repository->find($entidadeEnviada);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }

        $entidadeExistente
            ->setCrm($entidadeEnviada->getCrm())
            ->setNome($entidadeEnviada->getNome())
            ->setEspecialidade($entidadeEnviada->getEspecialidade());

        return $entidadeExistente;
    }
}