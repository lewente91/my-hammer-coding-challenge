<?php

namespace MyHammer\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class City
 * @package MyHammer\Api\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="cities")
 */
class City
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(name="zip", type="string")
     */
    protected $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip): self
    {
        $this->zip = $zip;

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
