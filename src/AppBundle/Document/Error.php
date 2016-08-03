<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * @ES\Document()
 */
class Error
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
     * @var \ErrorParam
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersPost;

    /**
     * @var \ErrorParam
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersSession;

    /**
     * @var \ErrorParam
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $parametersCookie;

    /**
     * @var \ErrorParam
     *
     * @ES\Embedded(class="AppBundle:ErrorParam", multiple=true)
     */
    public $serverEnv;

    /**
     * @var ErrorIp
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
}
