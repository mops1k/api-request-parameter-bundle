<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Type;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;

/**
 * Class DateTimeType
 */
class DateTimeType implements ApiRequestTypeInterface
{
    /**
     * @inheritdoc
     */
    public function validate($value, ?ApiRequestParameterInterface $apiRequestParameter = null): bool
    {
        return !(false === \DateTime::createFromFormat('Y-m-d_H:i:s', $value));
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse($value)
    {
        return \DateTime::createFromFormat('Y-m-d_H:i:s', $value);
    }

    /**
     * @return array
     */
    public function getNames(): array
    {
        return ['datetime'];
    }
}
