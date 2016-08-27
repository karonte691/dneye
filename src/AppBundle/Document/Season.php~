<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\SeasonRepository")
 */
class Season
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $totalSeason;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $season;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $imdb;
    
    /** @MongoDB\ReferenceOne(targetDocument="Item", inversedBy="season") */
    protected $item;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Episode", mappedBy="season")
     * */
    protected $episode;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set totalSeason
     *
     * @param int $totalSeason
     * @return self
     */
    public function setTotalSeason($totalSeason)
    {
        $this->totalSeason = $totalSeason;
        return $this;
    }

    /**
     * Get totalSeason
     *
     * @return int $totalSeason
     */
    public function getTotalSeason()
    {
        return $this->totalSeason;
    }

    /**
     * Set item
     *
     * @param AppBundle\Document\Item $item
     * @return self
     */
    public function setItem(\AppBundle\Document\Item $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * Get item
     *
     * @return AppBundle\Document\Item $item
     */
    public function getItem()
    {
        return $this->item;
    }
    public function __construct()
    {
        $this->episode = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add episode
     *
     * @param AppBundle\Document\Episode $episode
     */
    public function addEpisode(\AppBundle\Document\Episode $episode)
    {
        $this->episode[] = $episode;
    }

    /**
     * Remove episode
     *
     * @param AppBundle\Document\Episode $episode
     */
    public function removeEpisode(\AppBundle\Document\Episode $episode)
    {
        $this->episode->removeElement($episode);
    }

    /**
     * Get episode
     *
     * @return \Doctrine\Common\Collections\Collection $episode
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * Set season
     *
     * @param int $season
     * @return self
     */
    public function setSeason($season)
    {
        $this->season = $season;
        return $this;
    }

    /**
     * Get season
     *
     * @return int $season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set imdb
     *
     * @param string $imdb
     * @return self
     */
    public function setImdb($imdb)
    {
        $this->imdb = $imdb;
        return $this;
    }

    /**
     * Get imdb
     *
     * @return string $imdb
     */
    public function getImdb()
    {
        return $this->imdb;
    }
}
