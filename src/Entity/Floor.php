<?php

namespace App\Entity;

use JsonSerializable;

use App\Repository\FloorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FloorRepository::class)
 * @UniqueEntity(
 *  fields={"code"},
 *  message="floor.code.unique"
 * )
 */
class Floor implements JsonSerializable
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

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $is_deleted = 0;

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

    public function soft_delete(){
        $this->is_deleted = 1;
    }

    public function restore(){
        $this->is_deleted = 0;
    }

    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'rows' => $this->total_rows,
            'cols' => $this->total_cols,
        ];
    }
}
