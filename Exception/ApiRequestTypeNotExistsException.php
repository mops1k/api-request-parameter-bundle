<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiRequestTypeNotExistsException
 */
class ApiRequestTypeNotExistsException extends BadRequestHttpException
{
    /**
     * ApiRequestTypeNotExistsException constructor.
     *
     * @param string          $typeName
     * @param \Exception|null $previous
     * @param int             $code
     * @param array           $headers
     */
    public function __construct(string $typeName, \Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(\sprintf('Type "%s" does not exists', $typeName), $previous, $code, $headers);
    }
}
