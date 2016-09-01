<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Document;

use MongoDB\BSON\Persistable;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * @ES\Document()
 */
class Error implements Persistable
{
    /**
     * @var string
     *
     * @ES\Id()
     */
    public $id;

    /**
     * @var string
     *
     * @ES\Property(name="error_class", type="string")
     */
    public $errorClass;

    /**
     * @var string
     *
     * @ES\Property(name="url", type="string")
     */
    public $url;

    /**
     * @var string
     *
     * @ES\Property(name="message", type="string")
     */
    public $message;

    /**
     * @var string
     *
     * @ES\Property(name="occurred", type="date")
     */
    public $occurred;

    /**
     * @var string
     *
     * @ES\Property(name="backtrace", type="string")
     */
    public $backtrace;

    /**
     * @var ErrorParam[]
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersPost;

    /**
     * @var ErrorParam[]
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersSession;

    /**
     * @var ErrorParam[]
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersCookie;

    /**
     * @var ErrorParam[]
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $serverEnv;

    /**
     * @var ErrorIp[]
     *
     * @ES\Embedded(class="AppBundle:ErrorIp", multiple=true)
     */
    public $ips;
    
    /**
     * @var string
     *
     * @ES\Property(name="env", type="string")
     */
    public $env;

    /**
     * @var string
     *
     * @ES\Property(name="app", type="string")
     */
    public $app;

    /**
     * @var string
     *
     * @ES\Property(name="user", type="string")
     */
    public $user;

    /**
     * @var string
     *
     * @ES\Property(name="method", type="string")
     */
    public $method;

    /**
     * Serialize BSON to save in MongoDB
     *
     * @return array
     */
    public function bsonSerialize()
    {
        return [
            '_id' => $this->id,
            'errorClass' => $this->errorClass,
            'message' => $this->message,
            'occurred' => $this->occurred,
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
