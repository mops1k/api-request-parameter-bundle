<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestPatternNotMatch
 */
class ApiRequestPatternNotMatchException extends BadRequestHttpException
{
    /**
     * ApiRequestPatternNotMatchException constructor.
     *
     * @param ApiRequestParameterInterface $apiRequestParameter
     * @param string                       $pattern
     * @param \Exception|null              $previous
     * @param int                          $code
     * @param array                        $headers
     */
    public function __construct(
        ApiRequestParameterInterface $apiRequestParameter,
        string $pattern,
        \Exception $previous = null,
        int $code = 400,
        array $headers = []
    ) {
        parent::__construct(
            \sprintf(
                'Parameter "%s" does not match pattern "%s"',
                $apiRequestParameter->name,
                $pattern
            ),
            $previous,
            $code,
            $headers
        );
    }
}
