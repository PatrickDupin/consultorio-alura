<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EspecialidadeFactory;
use App\Repository\EspecialidadesRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends BaseController
{
    public function __construct(
        EntityManagerInterface   $entityManager,
        EspecialidadesRepository $especialidadesRepository,
        EspecialidadeFactory     $especialidadeFactory
    ) {
        parent::__construct(
            $entityManager,
            $especialidadesRepository,
            $especialidadeFactory
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
        $entidadeExistente->setDescricao($entidadeEnviada->getDescricao());
    }
}
