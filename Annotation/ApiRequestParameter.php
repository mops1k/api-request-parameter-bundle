<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiQueryParameter
 *
 * @Annotation()
 */
class ApiRequestParameter implements ApiRequestParameterInterface
{
    /** @var array */
    public $methods = [Request::METHOD_POST, Request::METHOD_GET];

    /** @var string */
    public $name;

    /** @var string */
    public $type = 'string';

    /** @var string */
    public $innerType;

    /** @var mixed */
    public $default;

    /** @var bool */
    public $required = false;

    /** @var string */
    public $pattern;

    /** @var int */
    public $max;

    /** @var int */
    public $min;
}
