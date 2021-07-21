<?php

namespace ReceptionSDK\Models;

class Schedule
{
    /**
     * The schedule's entity. For example: 'Section', 'Product'
     * @var Entity
     */
    private $entity;
    /**
     * The schedule from
     * @var string
     */
    private $from;
    /**
     * The schedule to
     * @var string
     */
    private $to;
    /**
     * The schedule day
     * @var int
     */
    private $day;


    /**
     * Default Section constructor
     */
    function __construct() { }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

}
