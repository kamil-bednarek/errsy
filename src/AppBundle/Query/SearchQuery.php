<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Query;

use ONGR\ElasticsearchDSL\Query\TermQuery;

class SearchQuery
{
    const FIELD_EXCEPTION_MESSAGE = 'message';
    const FIELD_EXCEPTION_TRACE = 'backtrace';

    /**
     * Get query for searching in exception message
     *
     * @param $searchString
     *
     * @return TermQuery
     */
    public function getQuerySearchByMessage($searchString)
    {
        return new TermQuery(self::FIELD_EXCEPTION_MESSAGE, $searchString);
    }

    /**
     * Get query for searching in backtrace
     *
     * @param $searchString
     *
     * @return TermQuery
     */
    public function getQuerySearchByBacktrace($searchString)
    {
        return new TermQuery(self::FIELD_EXCEPTION_TRACE, $searchString);
    }
}
