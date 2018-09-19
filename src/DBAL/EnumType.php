<?php

namespace MyHammer\Api\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

/**
 * Class EnumType
 * @package MyHammer\Api\DBAL
 */
abstract class EnumType extends Type
{
    /** @var string */
    protected $name;

    /** @var string[] */
    protected $values = [];

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(
            function ($value) {
                return "'" . $value . "'";
            },
            $this->values
        );

        return "ENUM(" . implode(", ", $values) . ")";
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values)) {
            throw new InvalidArgumentException("Invalid '" . $this->name . "' value.");
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
