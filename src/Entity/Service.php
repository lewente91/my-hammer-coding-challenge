<?php

namespace MyHammer\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Service
 * @package MyHammer\Api\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="services")
 */
class Service
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", unique=true, type="string")
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
