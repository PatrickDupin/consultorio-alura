<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadesRepository;

class MedicoFactory implements EntidadeFactory
{
    /**
     * @var EspecialidadesRepository
     */
    private $especialidadeRepository;

    /**
     * @param EspecialidadesRepository $especialidadeRepository
     */
    public function __construct(EspecialidadesRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarEntidade(string $json): Medico
    {
        $dadosEmJson = json_decode($json);
        $this->checkAllProperties($dadosEmJson);

        $especialidadeId = $dadosEmJson->especialidadeId;
        $especialidade = $this->especialidadeRepository->find($especialidadeId);

        $medico = new Medico();
        $medico
            ->setCrm($dadosEmJson->crm)
            ->setNome($dadosEmJson->nome)
            ->setEspecialidade($especialidade);

        return $medico;
    }

    /**
     * @param $dadosEmJson
     * @throws EntityFactoryException
     */
    private function checkAllProperties(object $dadosEmJson): void
    {
        if (!property_exists($dadosEmJson, 'nome')) {
            throw new EntityFactoryException('Médico precisa de nome');
        }

        if (!property_exists($dadosEmJson, 'crm')) {
            throw new EntityFactoryException('Médico precisa de CRM');
        }

        if (!property_exists($dadosEmJson, 'especialidadeId')) {
            throw new EntityFactoryException('Médico precisa de especialidade');
        }
    }
}