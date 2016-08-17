<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\EventListener;

use AppBundle\Service\ErkamService;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 *
 * @package AppBundle\EventListener
 *
 * @author  Kamil Bednarek <kb@protonmail.ch>
 */
class ExceptionListener
{
    /**
     * @var array
     */
    protected $ignoredExceptions;

    /**
     * @var ErkamService
     */
    protected $erkam;

    /**
     * Class constructor
     * @param array $ignoredExceptions
     */
    public function __construct(ErkamService $erkamService, array $ignoredExceptions = [])
    {
        $this->ignoredExceptions = $ignoredExceptions;
        $this->erkam = $erkamService;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        foreach ($this->ignoredExceptions as $ignoredException) {
            if ($exception instanceof $ignoredException) {
                return;
            }
        }

        $this->erkam->handleException($exception);
    }
}
