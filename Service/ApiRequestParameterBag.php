<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Service;

use ApiRequestParameterBundle\Annotation\ApiRequestParameter;
use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class ApiRequestCollector
 */
class ApiRequestParameterBag
{
    /**
     * @var ParameterBag
     */
    private $parameterBag;

    /**
     * ApiRequestCollector constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameterBag = new ParameterBag($parameters);
    }

    /**
     * @param ApiRequestParameter $apiRequestParameter
     * @param mixed               $value
     *
     * @return ApiRequestParameterBag
     */
    public function add(ApiRequestParameterInterface $apiRequestParameter, $value)
    {
        $this->parameterBag->set($apiRequestParameter->name, $value);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->parameterBag->get($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return $this->parameterBag->has($name);
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->parameterBag = new ParameterBag([]);

        return $this;
    }
}
