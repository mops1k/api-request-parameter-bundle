<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use ApiRequestParameterBundle\Annotation\ApiRequestParameter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestException
 */
class ApiRequestParameterRequiredException extends BadRequestHttpException
{
    /**
     * ApiRequestParameterNotFoundException constructor.
     *
     * @param ApiRequestParameter $apiRequestParameter
     * @param \Exception|null     $previous
     * @param int                 $code
     * @param array               $headers
     */
    public function __construct(
        ApiRequestParameter $apiRequestParameter,
        \Exception $previous = null,
        int $code = 400,
        array $headers = []
    ) {
        parent::__construct(
            sprintf('Request parameter "%s" is required', $apiRequestParameter->name),
            $previous,
            $code,
            $headers
        );
    }
}
