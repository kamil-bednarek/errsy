<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Controller;

use AppBundle\Document\Error;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * Route to save proper data to MongoDB service
     * This is also fallback for first version with Elasticsearch Data
     *
     * @Route("/api/v1/error/_batch", name="api_batch_insert")
     */
    public function batchInsertAction(Request $request)
    {
        $content = json_decode($request->getContent());

        if (true === is_array($content)) {
            foreach ($content as $exception) {
                $error = new Error();
                $error->message = $exception->message;
                $error->app = $exception->app;
                $error->backtrace = $exception->backtrace;
                $error->env = $exception->env;
                $error->method = $exception->method;
                $error->errorClass = $exception->errorClass;
                $error->url = $exception->url;
                $error->user = $exception->user;

                if (true === is_array($exception->parametersPost)) {
                    foreach ($exception->parametersPost as $param) {
                        $error->addParametersPosts($param->key, $param->value);
                    }
                }

                if (true === is_array($exception->parametersCookie)) {
                    foreach ($exception->parametersCookie as $param) {
                        $error->addParametersCookies($param->key, $param->value);
                    }
                }

                if (true === is_array($exception->parametersSession)) {
                    foreach ($exception->parametersSession as $param) {
                        $error->addParametersSessions($param->key, $param->value);
                    }
                }

                if (true === is_array($exception->serverEnv)) {
                    foreach ($exception->serverEnv as $env) {
                        $error->addServerEnvs($env->key, $env->value);
                    }
                }

                if (true === is_array($exception->ips)) {
                    foreach ($exception->ips as $ip) {
                        $error->addIps($ip->ip);
                    }
                }

                $this->get('mongodb_provider')->getCollection('error')->insertOne($error);
            }
        }
    }
}
