<?php

namespace MyHammer\Api\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ConstraintViolationException
 * @package MyHammer\Api\Exception
 */
class ConstraintViolationException extends AbstractApiException
{
    /** @var string */
    protected $errorCode = 'CONSTRAINT_VIOLATION';

    /** @var ConstraintViolationListInterface */
    protected $constraintViolationList;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function setConstraintViolationList(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        $messages = [];
        /** @var ConstraintViolation $constraintViolation */
        foreach ($this->constraintViolationList as $constraintViolation) {
            $messages[$constraintViolation->getPropertyPath()] = $constraintViolation->getMessage();
        }

        return $messages;
    }
}
