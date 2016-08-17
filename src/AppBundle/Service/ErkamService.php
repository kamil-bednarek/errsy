<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Service;

use AppBundle\Document\Error;
use AppBundle\Document\ErrorIp;
use AppBundle\Document\ErrorParam;
use ONGR\ElasticsearchBundle\Collection\Collection;
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
        $manager = $this->getRepo()->getManager();

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
        $error->ips = new Collection();
        $error->parametersCookie = new Collection();
        $error->parametersSession = new Collection();
        $error->parametersPost = new Collection();
        $error->serverEnv = new Collection();

        // Fetch client ip address
        foreach ($request->getClientIps() as $ip) {
            $ipObj = new ErrorIp();
            $ipObj->ip = $ip;
            $error->ips[] = $ipObj;
        }

        // Fetch cookies
        foreach ($request->cookies->all() as $key => $value) {
            $obj = new ErrorParam();
            $obj->key = $key;
            $obj->value = $value;
            $error->parametersCookie[] = $obj;
        }

        // Fetch POST
        foreach ($request->request->all() as $key => $value) {
            $obj = new ErrorParam();
            $obj->key = $key;
            $obj->value = $value;
            $error->parametersPost[] = $obj;
        }

        // Fetch SERVER
        foreach ($request->server->all() as $key => $value) {
            $obj = new ErrorParam();
            $obj->key = $key;
            $obj->value = $value;
            $error->serverEnv[] = $obj;
        }

        // Fetch SESSION
        foreach ($request->getSession()->all() as $key => $value) {
            $obj = new ErrorParam();
            $obj->key = $key;
            $obj->value = $value;
            $error->parametersSession[] = $obj;
        }

        $manager->persist($error);
        $manager->commit();
    }
}
