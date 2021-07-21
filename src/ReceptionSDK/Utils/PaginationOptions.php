<?php

namespace ReceptionSDK\Utils;

class PaginationOptions
{

    private $offset = 0;

    private $limit = 15;

    /**
     * PaginationOptions constructor.
     */
    private function __construct()
    {
    }

    public static function create()
    {
        return new PaginationOptions();
    }

    public function next()
    {
        $this->offset += $this->limit;
        return $this;
    }

    public function withOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param $limit
     * @return PaginationOptions
     */
    public function withLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }



}