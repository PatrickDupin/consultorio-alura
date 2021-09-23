<?php

namespace App\Entity;

use App\Entity\Especialidade;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $crm;
    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCrm(): ?int
    {
        return $this->crm;
    }

    /**
     * @param mixed $crm
     * @return Medico
     */
    public function setCrm(int $crm): self
    {
        $this->crm = $crm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Medico
     */
    public function setNome(string$nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'crm' => $this->getCrm(),
            'nome' => $this->getNome(),
            'especialidadeId' => $this->getEspecialidade()->getId()
        ];
    }
}