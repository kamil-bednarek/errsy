<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Document;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDatetime;

class ErrorFixes implements Persistable
{
    /**
     * @var string
     */
    public $id;

    public $count;

    public $date;

    /**
     * Serialize BSON to save in MongoDB
     *
     * @return array
     */
    public function bsonSerialize()
    {
        return [
            'count' => $this->count,
            'date' => new UTCDatetime(round(microtime(true) * 1000)),
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
        $this->count = $data['count'];
        $this->date = $data['date'];
    }
}
