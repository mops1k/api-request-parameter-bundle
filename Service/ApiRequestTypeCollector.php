<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Service;

use ApiRequestParameterBundle\Exception\ApiRequestTypeNotExistsException;
use ApiRequestParameterBundle\Type\ApiRequestTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ApiRequestTypeCollector
 */
class ApiRequestTypeCollector
{
    /**
     * @var array
     */
    private $types = [];

    /**
     * @param ApiRequestTypeInterface $type
     *
     * @return $this
     */
    public function addType(ApiRequestTypeInterface $type)
    {
        foreach ($type->getNames() as $name) {
            $this->types[$name] = $type;
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ApiRequestTypeInterface
     *
     * @throws ApiRequestTypeNotExistsException
     */
    public function getType(string $name)
    {
        if (!isset($this->types[$name])) {
            throw new ApiRequestTypeNotExistsException($name);
        }

        return $this->types[$name];
    }
}
