<?php

namespace MyHammer\Api\Exception;

/**
 * Class EntityNotFoundException
 * @package MyHammer\Api\Exception
 */
class EntityNotFoundException extends AbstractApiException
{
    /** @var string */
    protected $errorCode = 'ENTITY_NOT_FOUND';
}
