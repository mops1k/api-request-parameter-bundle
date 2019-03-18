<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class CatchApiException
 *
 * @Annotation()
 */
class CatchApiException
{
    /** @var bool */
    public $enabled = true;
}
