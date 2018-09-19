<?php

namespace MyHammer\Api\DBAL;

use MyHammer\Api\Entity\Schedule;

/**
 * Class EnumScheduleType
 * @package MyHammer\Api\DBAL
 */
class EnumScheduleType extends EnumType
{
    /** @var string */
    protected $name = 'enumSchedule';

    /** @var string[] */
    protected $values = Schedule::VALUES;
}
