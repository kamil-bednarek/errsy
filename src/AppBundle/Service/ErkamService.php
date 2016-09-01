<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Service;

use AppBundle\Document\Error;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ErkamService
 *
 * @package AppBundle\Service
 *
 * @author  Kamil Bednarek <kb@protonmail.ch>
 */
class ErkamService
{
    use ErkamServiceTrait;

    /**
     * @var null|RequestStack
     */
    private $requestStack = null;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function handleException(\Exception $exception)
    {
        $request = $this->requestStack->getCurrentRequest();
        $error = new Error();
        $error->app = 'erkam';
        $error->backtrace = $exception->getTraceAsString();
        $error->env = 'prod';
        $error->message = $exception->getMessage();
        $error->occurred = new \DateTime('now');
        $error->url = $request->getSchemeAndHttpHost().$request->getRequestUri();
        $error->user = $request->getUser();
        $error->method = $request->getMethod();


        // Fetch client ip address
        foreach ($request->getClientIps() as $ip) {
            $error->addIps($ip);
        }

        // Fetch cookies
        foreach ($request->cookies->all() as $key => $value) {
            $error->addParametersCookies($key, $value);
        }

        // Fetch POST
        foreach ($request->request->all() as $key => $value) {
            $error->addParametersPosts($key, $value);
        }

        // Fetch SERVER
        foreach ($request->server->all() as $key => $value) {
            $error->addServerEnvs($key, $value);
        }

        // Fetch SESSION
        foreach ($request->getSession()->all() as $key => $value) {
            $error->addParametersSessions($key, $value);
        }

        $this->getProvider()->getCollection('error')->insertOne($error);
    }
}
