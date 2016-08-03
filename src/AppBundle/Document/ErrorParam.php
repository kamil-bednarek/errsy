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
 * @ES\Object()
 */
class ErrorParam
{
    /**
     * @ES\Property(type="string")
     */
    public $key;

    /**
     * @ES\Property(type="string")
     */
    public $value;
}
