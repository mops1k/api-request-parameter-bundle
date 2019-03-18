<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestNameRequiredException
 */
class ApiRequestNameRequiredException extends BadRequestHttpException
{
    public function __construct(\Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct('Name is required option for api request parameter', $previous, $code, $headers);
    }
}
