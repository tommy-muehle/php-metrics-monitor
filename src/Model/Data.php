<?php

namespace MetricsMonitor\Model;

/**
 * @package MetricsMonitor\Model
 */
class Data
{
    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var float
     */
    private $score;

    /**
     * @param string    $type
     * @param \DateTime $date
     * @param float     $score
     * @param string    $slug
     */
    public function __construct($type, \DateTime $date, $score, $slug = null)
    {
        $this->slug = $slug;
        $this->type = $type;
        $this->date = $date;
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }
}
