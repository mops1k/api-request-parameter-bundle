<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ApiRequestTypeCollectorCompilerPass
 */
class ApiRequestTypeCollectorCompilerPass implements CompilerPassInterface
{
    public const TYPE_SERVICE_TAG = 'api_request.type';

    /**
     * @inheritdoc
     *
     * @throws \Exception
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TYPE_SERVICE_TAG);
        $collector = $container->getDefinition('ApiRequestParameterBundle\Service\ApiRequestTypeCollector');

        foreach ($taggedServices as $key => $service) {
            $collector->addMethodCall('addType', [$container->getDefinition($key)]);
        }
    }
}
