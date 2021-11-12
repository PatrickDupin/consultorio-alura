<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EspecialidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Repository\EspecialidadesRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends BaseController
{
    public function __construct(
        EntityManagerInterface   $entityManager,
        EspecialidadesRepository $especialidadesRepository,
        EspecialidadeFactory     $especialidadeFactory,
        ExtratorDadosRequest     $extratorDadosRequest
    ) {
        parent::__construct(
            $entityManager,
            $especialidadesRepository,
            $especialidadeFactory,
            $extratorDadosRequest
        );
    }

    /**
     * @param Especialidade $entidadeExistente
     * @param Especialidade $entidadeEnviada
     */
    public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada
    ) {
        /** @var Especialidade $entidadeExistente */
        $entidadeExistente = $this->repository->find($entidadeEnviada);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }

        $entidadeExistente->setDescricao($entidadeEnviada->getDescricao());

        return $entidadeExistente;
    }
}
