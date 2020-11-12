<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Type;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;

/**
 * Class IntegerType
 */
class IntegerType implements ApiRequestTypeInterface
{

    /**
     * @inheritdoc
     */
    public function validate($value, ?ApiRequestParameterInterface $apiRequestParameter = null): bool
    {
        return !(null === filter_var($value, \FILTER_VALIDATE_INT, \FILTER_NULL_ON_FAILURE));
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse($value)
    {
        return filter_var($value, \FILTER_VALIDATE_INT, \FILTER_NULL_ON_FAILURE);
    }

    /**
     * @return array
     */
    public function getNames(): array
    {
        return ['int', 'integer'];
    }
}
