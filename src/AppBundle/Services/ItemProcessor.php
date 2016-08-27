<?php


namespace AppBundle\Services;

use AppBundle\Document\Episode;
use AppBundle\Document\Season;
use Doctrine\ODM\MongoDB\DocumentManager;
use GuzzleHttp\Client;
use Symfony\Component\Config\Definition\Exception\Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Mmoreram\GearmanBundle\Driver\Gearman;

use AppBundle\Document\Item;

/**
 * @Gearman\Work (
 *   description = "Imdb json processor",
 *   defaultMethod = "processItem",
 *   service="background_worker"
 * )
 */
class ItemProcessor
{
    protected $imdbUrl;
    protected $imdbSeasonUrl;
    protected $imdbEpisodeUrl;
    protected $dm;

    function __construct(DocumentManager $dm,$imdbUrl,$imdbSeasonUrl,$imdbEpisodeUrl) {
        $this->imdbUrl = $imdbUrl;
        $this->imdbSeasonUrl = $imdbSeasonUrl;
        $this->imdbEpisodeUrl = $imdbEpisodeUrl;
        $this->dm = $dm;
    }


    /**
     * @Gearman\Job(
     *   defaultMethod = "doBackground",
     *   description = "test desc"
     * )
     *
     * @param \GearmanJob $job Object with job parameters
     * @return boolean
    */
    public function discoverImdb(\GearmanJob $job)
    {
        echo "start\n";
        try {
            $params = unserialize($job->workload());

            if(array_key_exists('sTerm', $params))
            {
                $this->processItem($params['sTerm']);
            }
            else
                throw new \Exception('params array not contain sTerm value');

        } catch (\Exception $e) {
            //var_dump($e->getMessage());
        }

        return true;
    }


    /*
     *  Process imdb search term. It will be send a GET request to www.omdbapi.com api and parse and save
     *  the json return object. If item "type" param will be equals to "series", this function will send multiple request
     *  for parsing the seasons and the episodes
     *
     *  @param string $var - the search term to send to imdb
     *  @return none
     */
    public function processItem($var)
    {
        try
        {
            //process imdb json response
            $imdbItemJson = $this->processImdb($var, $this->imdbUrl);


            if(!$imdbItemJson || !is_array($imdbItemJson))
                throw new Exception('UNABLE_RETRIEVE_ITEM');

            //store it in item document object
            $item = $this->mapImdbJsonToItem($imdbItemJson);

            $this->dm->persist($item);


            if($imdbItemJson['Type'] == 'series')
            {
                //it's a tv series, we need to import season and episodes
                $seasonsArray = $this->processIMdbSeason($item->getImdbId(), $item->getTotalseasons());

                if(!$seasonsArray || !is_array($seasonsArray))
                    throw new Exception('UNABLE_RETRIEVE_SEASON');

                //now we have the seasons json array, let's loop it for episodes
                foreach($seasonsArray as $season)
                {
                    $seasonItem = $this->mapSeasonJsonToItem($season, $item->getImdbId());

                    $seasonItem->setItem($item);

                    $this->dm->persist($seasonItem);

                    foreach($season['Episodes'] as $episodeJsonObject)
                    {
                        $episodeJson = $this->processImdb($episodeJsonObject['imdbID'],$this->imdbEpisodeUrl);

                        $episodeItem = $this->mapEpisodeJsonToItem($episodeJson);

                        $seasonItem->addEpisode($episodeItem);

                        $episodeItem->setSeason($seasonItem);

                        $this->dm->persist($episodeItem);


                    }
                    $item->addSeason($seasonItem);


                }
            }


            $this->dm->flush();
        }
        catch(\Exception $e)
        {

        }
    }


    /*
     *  Send a http get request to imdb api.
     *
     *  @param string $key - the search term to send to imdb
     *  @param string $imdbUrl - imdb api url
     *  @return array $itemArray - the item json decode of api response
     */
    public function processImdb($key, $imdbUrl)
    {
        if(!$key)
            throw new Exception("Search term is empty!");

        $searchTermFormatted = str_replace(" ", "+", $key);
        $imdbUrl = sprintf($imdbUrl, $searchTermFormatted);

        $response = $this->doHttpRequest($imdbUrl);

        $imdbBodyContet = $response->getBody();

        if(empty($imdbBodyContet) || !$this->isJson($imdbBodyContet))
            throw new Exception('Response is empty or not valid json');

        $itemArray = json_decode($imdbBodyContet, true);

        return $itemArray;

    }

    /*
     *  Same thing of processImdb. The difference is that this function will loop and send "nbrSeason" request
     *  for parsing all the season json responses.
     *
     *  @param string $itemImdbId - imdb id of parent url
     *  @param int $nbrSeason - number of seasons (defined in itemArray array)
     *  @return array(array) $seasonsArray - array of array of json decode api response
     */
    public function processIMdbSeason($itemImdbId, $nbrSeason)
    {
        if(!$itemImdbId)
            throw new Exception('Imdb Id is empty!');

        if(!$nbrSeason)
            $nbrSeason = 1;

        $seasonsArray = array();

        for($i = 1; $i <= $nbrSeason; $i++)
        {
            try {
                $imdbSeasonUrl = sprintf($this->imdbSeasonUrl, $itemImdbId, $i);

                $response = $this->doHttpRequest($imdbSeasonUrl);

                $imdbBodyContet = $response->getBody();

                if (empty($imdbBodyContet) || !$this->isJson($imdbBodyContet))
                    throw new Exception('Response is empty or not valid json');

                $seasonsArray[] = json_decode($imdbBodyContet, true);
            }
            catch(Exception $e)
            {
                //something goes wrong....but continue anyway
                continue;
            }
        }
        return $seasonsArray;
    }

    /*
    *  this function provide the http request. We don't want to do it by our own, so we use GuzzleHttpBundle
    *
    *  @param string $url -  url
    *  @return string $response - The body response string.
     *
     */
    private function doHttpRequest($url)
    {
        $client = new Client([
            'timeout'  => 10.0,
        ]);

        try {
            $response = $client->request('GET', $url);

            return $response;

        } catch (RequestException $e) {
            throw new \Exception(Psr7\str($e->getResponse()));
        }

    }

    /*
   * check if a string is valid json format
   *
   *  @param string $string -  string to check
   *  @return bool  -  TRUE if the string is a valid json, otherwise FALSE
    *
    */
    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }



    /*
     *    ===================================================
     *    THERE MUST BE A WAY TO DO THE FUNCTION BELOW BETTER
     *     ===================================================
     */


    /*
     *  Map json response array to item document
     *
     *  @param array $itemArray - json item array
     *
     *  @return Document\Item $item
     */
    private function mapImdbJsonToItem($itemArray)
    {
        $item = new Item();

        $item->setTitle($itemArray['Title']);
        $item->setYear($itemArray['Year']);
        $item->setRating($itemArray['Rated']);
        $item->setReleased($itemArray['Released']);
        $item->setRuntime($itemArray['Runtime']);
        $item->setGenre($itemArray['Genre']);
        $item->setDirector($itemArray['Director']);
        $item->setWriters($itemArray['Writer']);
        $item->setActors($itemArray['Actors']);
        $item->setPlot($itemArray['Plot']);
        $item->setLanguage($itemArray['Language']);
        $item->setCountry($itemArray['Country']);
        $item->setPoster($itemArray['Poster']);
        $item->setMetascore($itemArray['Metascore']);
        $item->setImdbrating($itemArray['imdbRating']);
        $item->setImdbId($itemArray['imdbID']);
        $item->setType($itemArray['Type']);

        if($itemArray['Type'] == 'series')
        {
            $item->setTotalseasons($itemArray['totalSeasons']);
        }

        return $item;
    }

    /*
     *  Map json response array to season document
     *
     *  @param array season - json season array
     *  @param string imdbid - imdb id of parent item
     *  @return Document\Season $season
     */
    private function mapSeasonJsonToItem($seasonArray, $imdbId)
    {
        $season = new Season();

        $season->setTitle($seasonArray['Title']);
        $season->setTotalSeason($seasonArray['totalSeasons']);
        $season->setSeason($seasonArray['Season']);
        $season->setImdb($imdbId);

        return $season;
    }

    /*
     *  Map json response array to episode document
     *
     *  @param array $episodeArray - json episode array
     *
     *  @return Document\Episode $episode
     */
    private function mapEpisodeJsonToItem($episodeArray)
    {
        $episode = new Episode();

        $episode->setTitle($episodeArray['Title']);
        $episode->setYear($episodeArray['Year']);
        $episode->setRating($episodeArray['Rated']);
        $episode->setReleased($episodeArray['Released']);
        $episode->setEpisode($episodeArray['Episode']);
        $episode->setRuntime($episodeArray['Runtime']);
        $episode->setGenre($episodeArray['Genre']);
        $episode->setDirector($episodeArray['Director']);
        $episode->setWriters($episodeArray['Writer']);
        $episode->setActors($episodeArray['Actors']);
        $episode->setPlot($episodeArray['Plot']);
        $episode->setLanguage($episodeArray['Language']);
        $episode->setCountry($episodeArray['Country']);
        $episode->setPoster($episodeArray['Poster']);
        $episode->setMetascore($episodeArray['Metascore']);
        $episode->setImdbrating($episodeArray['imdbRating']);
        $episode->setImdbId($episodeArray['imdbID']);

        return $episode;
    }

}