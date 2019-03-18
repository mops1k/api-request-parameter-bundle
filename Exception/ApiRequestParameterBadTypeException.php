<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use ApiRequestParameterBundle\Annotation\ApiRequestParameter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestParameterBadType
 */
class ApiRequestParameterBadTypeException extends BadRequestHttpException
{
    /**
     * ApiRequestParameterBadType constructor.
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
        $message = \sprintf(
            'Value for parameter "%s" have a bad type. Required type is "%s"',
            $apiRequestParameter->name,
            $apiRequestParameter->type
        );

        if (isset($apiRequestParameter->innerType)) {
            $message = \sprintf(
                'Value for parameter "%s" have a bad type. Required type is "%s" and subtypes "%s"',
                $apiRequestParameter->name,
                $apiRequestParameter->type,
                $apiRequestParameter->innerType
            );
        }
        parent::__construct(
            $message,
            $previous,
            $code,
            $headers
        );
    }
}
