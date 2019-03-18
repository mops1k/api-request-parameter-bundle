<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Service;

use ApiRequestParameterBundle\Annotation\ApiRequestParameter;
use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;
use ApiRequestParameterBundle\Exception\ApiRequestBadMethodException;
use ApiRequestParameterBundle\Exception\ApiRequestParameterBadTypeException;
use ApiRequestParameterBundle\Exception\ApiRequestParameterRequiredException;
use ApiRequestParameterBundle\Exception\ApiRequestPatternNotMatchException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiValidator
 */
class ApiRequestFilter
{
    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @var ApiRequestTypeCollector
     */
    private $typeCollector;

    /**
     * ApiRequestFilter constructor.
     *
     * @param Parameters              $parameters
     * @param ApiRequestTypeCollector $typeCollector
     */
    public function __construct(Parameters $parameters, ApiRequestTypeCollector $typeCollector)
    {
        $this->parameters    = $parameters;
        $this->typeCollector = $typeCollector;
    }

    /**
     * @param Request                                          $request
     * @param ApiRequestParameter|ApiRequestParameterInterface $apiRequestParameter
     *
     * @return bool|mixed|null
     *
     * @throws \ApiRequestParameterBundle\Exception\ApiRequestTypeNotExistsException
     */
    public function filter(Request $request, ApiRequestParameterInterface $apiRequestParameter)
    {
        if (!in_array($request->getMethod(), $apiRequestParameter->methods, true)) {
            throw new ApiRequestBadMethodException($apiRequestParameter);
        }

        $default = (null === $apiRequestParameter->default) ? null : str_replace('%', '', $apiRequestParameter->default);
        if (null !== $default && $this->parameters->hasParameter($default)) {
            $default = '#^('.$this->parameters->get($default).')$#';
        }

        if ($request->query->has($apiRequestParameter->name)) {
            $parameter = $request->query->get($apiRequestParameter->name, $default);
        }

        if (!isset($parameter) && $request->request->has($apiRequestParameter->name)) {
            $parameter = $request->request->get($apiRequestParameter->name, $default);
        }

        if (empty($parameter) && $apiRequestParameter->required) {
            if (null !== $default) {
                return $default;
            }

            throw new ApiRequestParameterRequiredException($apiRequestParameter);
        }

        if (empty($parameter)) {
            return null;
        }

        $type = $this->typeCollector->getType($apiRequestParameter->type);

        if (!$type->validate($parameter, $apiRequestParameter)) {
            throw new ApiRequestParameterBadTypeException($apiRequestParameter);
        }

        if ($apiRequestParameter->pattern) {
            $pattern = '#^'.$apiRequestParameter->pattern.'$#';

            $systemParameterName = str_replace('%', '', $apiRequestParameter->pattern);
            if ($this->parameters->hasParameter($systemParameterName)) {
                $pattern = '#^('.$this->parameters->get($systemParameterName).')$#';
            }

            if (!preg_match($pattern, $parameter)) {
                throw new ApiRequestPatternNotMatchException($apiRequestParameter, $pattern);
            }
        }

        return $type->parse($parameter);
    }
}
