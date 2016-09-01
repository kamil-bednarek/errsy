<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Document;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDatetime;

class Error implements Persistable
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $errorClass;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $occurred;

    /**
     * @var string
     */
    public $backtrace;

    /**
     * @var []
     */
    public $parametersPost;

    /**
     * @var []
     */
    public $parametersSession;

    /**
     * @var []
     */
    public $parametersCookie;

    /**
     * @var []
     */
    public $serverEnv;

    /**
     * @var []
     */
    public $ips;
    
    /**
     * @var string
     */
    public $env;

    /**
     * @var string
     */
    public $app;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $method;

    public function __construct()
    {
        $this->parametersPost = [];
        $this->parametersSession = [];
        $this->parametersCookie = [];
        $this->serverEnv = [];
        $this->ips = [];
    }

    /**
     * Method to add new cookie parameter
     *
     * @param $key
     * @param $value
     */
    public function addParametersCookies($key, $value)
    {
        if (false === is_array($this->parametersCookie)) {
            $this->parametersCookie = [];
        }
        $this->parametersCookie[$key] = $value;
    }

    /**
     * Method to add new post parameter
     *
     * @param $key
     * @param $value
     */
    public function addParametersPosts($key, $value)
    {
        if (false === is_array($this->parametersPost)) {
            $this->parametersPost = [];
        }
        $this->parametersCookie[$key] = $value;
    }

    /**
     * Method to add new session parameter
     *
     * @param $key
     * @param $value
     */
    public function addParametersSessions($key, $value)
    {
        if (false === is_array($this->parametersSession)) {
            $this->parametersSession = [];
        }
        $this->parametersSession[$key] = $value;
    }

    /**
     * Method to add new server environment
     *
     * @param $key
     * @param $value
     */
    public function addServerEnvs($key, $value)
    {
        if (false === is_array($this->serverEnv)) {
            $this->serverEnv = [];
        }
        $this->serverEnv[$key] = $value;
    }

    /**
     * Method to add new ip address
     *
     * @param $address
     */
    public function addIps($address)
    {
        if (false === is_array($this->ips)) {
            $this->ips = [];
        }

        $this->ips[] = $address;
    }

    /**
     * Serialize BSON to save in MongoDB
     *
     * @return array
     */
    public function bsonSerialize()
    {
        return [
            'errorClass' => $this->errorClass,
            'message' => $this->message,
            'occurred' => new UTCDatetime(round(microtime(true) * 1000)),
            'backtrace' => $this->backtrace,
            'parametersPost' => $this->parametersPost,
            'parametersSession' => $this->parametersSession,
            'parametersCookie' => $this->parametersCookie,
            'serverEnv' => $this->serverEnv,
            'ips' => $this->ips,
            'env' => $this->env,
            'app' => $this->app,
            'user' => $this->user,
            'method' => $this->method,
        ];
    }

    /**
     * Deserialize BSON to PHP format from MongoDB
     *
     * @param array $data
     */
    public function bsonUnserialize(array $data)
    {
        $this->id = $data['_id'];
        $this->errorClass = $data['errorClass'];
        $this->message = $data['message'];
        $this->occurred = $data['occurred'];
        $this->backtrace = $data['backtrace'];
        $this->parametersPost = $data['parametersPost'];
        $this->parametersSession = $data['parametersSession'];
        $this->parametersCookie = $data['parametersCookie'];
        $this->serverEnv = $data['serverEnv'];
        $this->ips = $data['ips'];
        $this->env = $data['env'];
        $this->app = $data['app'];
        $this->user = $data['user'];
        $this->method = $data['method'];
    }
}
