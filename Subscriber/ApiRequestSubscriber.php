<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Subscriber;

use ApiRequestParameterBundle\Annotation\ApiRequestParameterInterface;
use ApiRequestParameterBundle\Exception\ApiRequestNameRequiredException;
use ApiRequestParameterBundle\Service\ApiRequestFilter;
use ApiRequestParameterBundle\Service\ApiRequestParameterBag;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiRequestSubscriber
 */
class ApiRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var Reader
     */
    private $reader;
    /**
     * @var ApiRequestFilter
     */
    private $apiRequestFilter;
    /**
     * @var ApiRequestParameterBag
     */
    private $apiRequestParameterBag;

    /**
     * ApiRequestSubscriber constructor.
     *
     * @param Reader                 $reader
     * @param ApiRequestFilter       $apiRequestFilter
     * @param ApiRequestParameterBag $apiRequestParameterBag
     */
    public function __construct(
        Reader $reader,
        ApiRequestFilter $apiRequestFilter,
        ApiRequestParameterBag $apiRequestParameterBag
    ) {
        $this->reader                 = $reader;
        $this->apiRequestFilter       = $apiRequestFilter;
        $this->apiRequestParameterBag = $apiRequestParameterBag;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [['onKernelController', 0]],
        ];
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws \ApiRequestParameterBundle\Exception\ApiRequestTypeNotExistsException
     * @throws \ReflectionException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->apiRequestParameterBag->clear();

        $request = $event->getRequest();
        $controller = $event->getController();

        if (!is_array($controller)) {
            $method = (new \ReflectionClass($controller))->getMethod('__invoke');
        } else {
            $method = (new \ReflectionClass($controller[0]))->getMethod($controller[1]);
        }

        $annotations = $this->reader->getMethodAnnotations($method);

        foreach ($annotations as $annotation) {
            if (!$annotation instanceof ApiRequestParameterInterface) {
                continue;
            }

            if (empty($annotation->name)) {
                throw new ApiRequestNameRequiredException();
            }

            $value = $this->apiRequestFilter->filter($request, $annotation);
            if (null !== $value) {
                $this->apiRequestParameterBag->add($annotation, $value);
            }
        }
    }
}
