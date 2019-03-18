<?php
declare(strict_types = 1);

namespace ApiRequestParameterBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Parameters
 *
 * @info Bridge, because ParameterBagInterface getting empty
 */
class Parameters
{
    /** @var ContainerInterface */
    private $container;

    /**
     * Parameters constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get parameter from parameterBag by it's name.
     *
     * @param string $name
     *
     * @return object
     */
    public function get(string $name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool
    {
        return $this->container->hasParameter($name);
    }

    /**
     * Get project directory.
     *
     * @return string
     */
    public function getProjectDir(): string
    {
        return $this->container->get('kernel')->getProjectDir();
    }

    /**
     * Get cache directory.
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->container->get('kernel')->getCacheDir();
    }
}
