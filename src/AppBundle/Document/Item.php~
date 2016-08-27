<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item
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
     * @MongoDB\Field(type="string")
     */
    protected $year;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $rating;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $released;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $runtime;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $genre;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $director;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $writers;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $actors;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $plot;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $language;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $country;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $awards;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $poster;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $metascore;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $imdbrating;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $type;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $totalseasons;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $imdbId;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Season", mappedBy="item")
     * */
    protected $season;

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
     * Set year
     *
     * @param string $year
     * @return self
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * Get year
     *
     * @return string $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return self
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get rating
     *
     * @return string $rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set released
     *
     * @param string $released
     * @return self
     */
    public function setReleased($released)
    {
        $this->released = $released;
        return $this;
    }

    /**
     * Get released
     *
     * @return string $released
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Set runtime
     *
     * @param string $runtime
     * @return self
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * Get runtime
     *
     * @return string $runtime
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return self
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * Get genre
     *
     * @return string $genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set director
     *
     * @param string $director
     * @return self
     */
    public function setDirector($director)
    {
        $this->director = $director;
        return $this;
    }

    /**
     * Get director
     *
     * @return string $director
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set actors
     *
     * @param string $actors
     * @return self
     */
    public function setActors($actors)
    {
        $this->actors = $actors;
        return $this;
    }

    /**
     * Get actors
     *
     * @return string $actors
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Set plot
     *
     * @param string $plot
     * @return self
     */
    public function setPlot($plot)
    {
        $this->plot = $plot;
        return $this;
    }

    /**
     * Get plot
     *
     * @return string $plot
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set awards
     *
     * @param string $awards
     * @return self
     */
    public function setAwards($awards)
    {
        $this->awards = $awards;
        return $this;
    }

    /**
     * Get awards
     *
     * @return string $awards
     */
    public function getAwards()
    {
        return $this->awards;
    }

    /**
     * Set poster
     *
     * @param string $poster
     * @return self
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
        return $this;
    }

    /**
     * Get poster
     *
     * @return string $poster
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set metascore
     *
     * @param string $metascore
     * @return self
     */
    public function setMetascore($metascore)
    {
        $this->metascore = $metascore;
        return $this;
    }

    /**
     * Get metascore
     *
     * @return string $metascore
     */
    public function getMetascore()
    {
        return $this->metascore;
    }

    /**
     * Set imdbrating
     *
     * @param string $imdbrating
     * @return self
     */
    public function setImdbrating($imdbrating)
    {
        $this->imdbrating = $imdbrating;
        return $this;
    }

    /**
     * Get imdbrating
     *
     * @return string $imdbrating
     */
    public function getImdbrating()
    {
        return $this->imdbrating;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set totalseasons
     *
     * @param string $totalseasons
     * @return self
     */
    public function setTotalseasons($totalseasons)
    {
        $this->totalseasons = $totalseasons;
        return $this;
    }

    /**
     * Get totalseasons
     *
     * @return string $totalseasons
     */
    public function getTotalseasons()
    {
        return $this->totalseasons;
    }

    public function __construct()
    {
        $this->season = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add season
     *
     * @param AppBundle\Document\Season $season
     */
    public function addSeason(\AppBundle\Document\Season $season)
    {
        $this->season[] = $season;
    }

    /**
     * Remove season
     *
     * @param AppBundle\Document\Season $season
     */
    public function removeSeason(\AppBundle\Document\Season $season)
    {
        $this->season->removeElement($season);
    }

    /**
     * Get season
     *
     * @return \Doctrine\Common\Collections\Collection $season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     * @return self
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;
        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string $imdbId
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set writers
     *
     * @param string $writers
     * @return self
     */
    public function setWriters($writers)
    {
        $this->writers = $writers;
        return $this;
    }

    /**
     * Get writers
     *
     * @return string $writers
     */
    public function getWriters()
    {
        return $this->writers;
    }

    /**
     * Set season
     *
     * @param AppBundle\Document\Season $season
     * @return self
     */
    public function setSeason(\AppBundle\Document\Season $season)
    {
        $this->season = $season;
        return $this;
    }
}
