<?php
declare(strict_types=1);

namespace ApiRequestParameterBundle\Subscriber;

use ApiRequestParameterBundle\Annotation\CatchApiException;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiRequestExceptionSubscriber
 */
class ApiRequestExceptionSubscriber implements EventSubscriberInterface
{
    /** @var bool */
    private $catchApiException = false;

    /** @var Reader */
    private $reader;
    /**
     * @var string
     */
    private $env = 'dev';

    /**
     * ApiRequestExceptionSubscriber constructor.
     *
     * @param Reader $reader
     * @param string $env
     */
    public function __construct(Reader $reader, string $env)
    {
        $this->reader = $reader;
        $this->env = $env;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [['onKernelController', 10]],
            KernelEvents::EXCEPTION  => 'onKernelException',
        ];
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws \ReflectionException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            $method = (new \ReflectionClass($controller))->getMethod('__invoke');
        } else {
            $method = (new \ReflectionClass($controller[0]))->getMethod($controller[1]);
        }

        $annotations = $this->reader->getMethodAnnotations($method);

        foreach ($annotations as $annotation) {
            if (!$annotation instanceof CatchApiException) {
                continue;
            }

            $this->catchApiException = $annotation->enabled;
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->catchApiException) {
            return;
        }

        $exception = $event->getException();

        $responseData = [
            'status' => false,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if (false !== \strpos($this->env, 'dev')) {
            $responseData['trace'] = $exception->getTrace();
            $responseData['file'] = $exception->getFile();
            $responseData['line'] = $exception->getLine();
            $responseData['link'] = \sprintf('phpstorm://open?file=%s&line=%s', $exception->getFile(), $exception->getLine());
        }

        $event->setResponse(new JsonResponse($responseData));
    }
}
