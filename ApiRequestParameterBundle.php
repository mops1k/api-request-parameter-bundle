<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle;

use ApiRequestParameterBundle\DependencyInjection\CompilerPass\ApiRequestTypeCollectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ApiRequestParameterBundle
 */
class ApiRequestParameterBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ApiRequestTypeCollectorCompilerPass());
    }
}
