<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Type;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;

/**
 * Interface ApiRequestTypeInterface
 */
interface ApiRequestTypeInterface
{
    /**
     * @param mixed                             $value
     * @param ApiRequestParameterInterface|null $apiRequestParameter
     *
     * @return bool
     */
    public function validate($value, ?ApiRequestParameterInterface $apiRequestParameter = null): bool;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parse($value);

    /**
     * @return array
     */
    public function getNames(): array;
}
