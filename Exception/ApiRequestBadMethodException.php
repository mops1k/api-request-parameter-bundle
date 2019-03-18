<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use ApiRequestParameterBundle\Annotation\ApiRequestParameter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestBadMethodException
 */
class ApiRequestBadMethodException extends BadRequestHttpException
{
    /**
     * ApiRequestBadMethodException constructor.
     *
     * @param ApiRequestParameter $apiRequestParameter
     * @param \Exception|null     $previous
     * @param int                 $code
     * @param array               $headers
     */
    public function __construct(
        ApiRequestParameter $apiRequestParameter,
        \Exception $previous = null,
        int $code = 405,
        array $headers = []
    ) {
        parent::__construct(
            sprintf(
                'Parameter "%s" required can be using only with methods: %s',
                $apiRequestParameter->name,
                \implode(', ', $apiRequestParameter->methods)
            ),
            $previous,
            $code,
            $headers
        );
    }
}
