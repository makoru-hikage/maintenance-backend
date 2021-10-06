<?php

namespace App\Entity;

use JsonSerializable;

use App\Repository\FloorAreaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FloorAreaRepository::class)
 * @UniqueEntity(
 *  fields={"area_code"},
 *  message="floorarea.code.unique"
 * )
 */
class FloorArea implements JsonSerializable
{
    const STATUSES = ['Available', 'Reserved', 'Unavailable', 'Occupied'];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $area_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $floor_row;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $floor_col;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices=FloorArea::STATUSES, message="Choose a valid status.")
     */
    private $status = 'Available';

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $is_deleted = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFloorId(): ?int
    {
        return $this->floor_id;
    }

    public function setFloorId(int $floor_id): self
    {
        $this->floor_id = $floor_id;

        return $this;
    }

    public function getAreaCode(): ?string
    {
        return $this->area_code;
    }

    public function setAreaCode(string $area_code): self
    {
        $this->area_code = $area_code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFloorRow(): ?int
    {
        return $this->floor_row;
    }

    public function setFloorRow(int $row): self
    {
        $this->floor_row = $row;

        return $this;
    }

    public function getFloorCol(): ?int
    {
        return $this->floor_col;
    }

    public function setFloorCol(int $col): self
    {
        $this->floor_col = $col;

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
            'area_code' => $this->area_code,
            'description' => $this->description,
            'row' => $this->floor_row,
            'col' => $this->floor_col,
        ];
    }
}
