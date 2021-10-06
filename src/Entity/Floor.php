<?php

namespace App\Entity;

use App\Repository\FloorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FloorRepository::class)
 * @UniqueEntity("code")
 */
class Floor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $total_rows;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $total_cols;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTotalRows(): ?int
    {
        return $this->total_rows;
    }

    public function setTotalRows(int $rows): self
    {
        $this->total_rows = $rows;

        return $this;
    }

    public function getTotalCols(): ?int
    {
        return $this->total_cols;
    }

    public function setTotalCols(int $cols): self
    {
        $this->total_cols = $cols;

        return $this;
    }
}
