<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Type;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;
use ApiRequestParameterBundle\Service\ApiRequestTypeCollector;

/**
 * Class ArrayType
 */
class ArrayType implements ApiRequestTypeInterface
{
    /**
     * @var ApiRequestTypeCollector
     */
    private $typeCollector;

    /**
     * @var ApiRequestTypeInterface
     */
    private $subType;

    /**
     * ArrayType constructor.
     *
     * @param ApiRequestTypeCollector $typeCollector
     */
    public function __construct(ApiRequestTypeCollector $typeCollector)
    {
        $this->typeCollector = $typeCollector;
    }

    /**
     * @inheritdoc
     *
     * @throws \ApiRequestParameterBundle\Exception\ApiRequestTypeNotExistsException
     */
    public function validate($value, ?ApiRequestParameterInterface $apiRequestParameter = null): bool
    {
        if (!is_array($value)) {
            return false;
        }

        if (!isset($apiRequestParameter->innerType) || null === $apiRequestParameter) {
            return true;
        }

        $this->subType = $this->typeCollector->getType($apiRequestParameter->innerType);
        foreach ($value as $item) {
            if (!$this->subType->validate($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $value
     *
     * @return mixed
     */
    public function parse($value)
    {
        if ($this->subType instanceof ApiRequestTypeInterface) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->subType->parse($item);
            }
        }

        return $value;
    }

    /**
     * @return array
     */
    public function getNames(): array
    {
        return ['array'];
    }
}
