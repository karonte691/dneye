<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends Controller
{
    /**
     * Display item details.
     * If it is a series item, the view will also display the seasons and the episode
     *
     * @param string $imdbid  imdb id of the item
     * @param string $title   item's title
     *
     *
     * @throws \NotFoundHttpException When imdbid is not provided or item is not longer available
     */
    public function itemAction($imdbid, $title)
    {
        if(!$imdbid || !$title)
            throw new NotFoundHttpException();

        $itemRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Item');

        $item = $itemRepository->findOneBy(['imdbId' => $imdbid]);

        if(!$item)
            throw new NotFoundHttpException();


        return $this->render('item/item.html.twig', [
            'item' => $item,
            'item_title' => $title,
        ]);

    }


    /**
     * Display episode details.
     *
     *
     * @param string $imdbid  imdb id of the episode
     *
     *
     * @throws \NotFoundHttpException When imdbid is not provided or the episode is not longer available
     */
    public function episodeAction($imdbid)
    {
        if(!$imdbid)
            throw new NotFoundHttpException();

        $EpisodeRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Episode');

        $episode = $EpisodeRepository->findOneBy(['imdbId' => $imdbid]);

        if(!$episode)
            throw new NotFoundHttpException();

        return $this->render('item/episode.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'episode' => $episode
        ]);
    }

    /**
     * Retrieve and display the imdb poster
     * Why not link it directly? because the motherfucker imdb does not allow to display directly the image
     * so we have to implement this wa
     *
     * @param Request $request
     * @param string  $url      url of item's poster
     *
     * @return string|null The transformed input
     *
     * @throws \NotFoundHttpException When imdbid is not provided or item is not longer available
     */
    public function getImdbImageAction(Request $request)
    {
        $url = $request->query->get('url');
        if(!empty($url)) {
            $image_mime = getimagesize($url)['mime'];
            header("Content-type: " . $image_mime);
            echo file_get_contents($url);
        }
    }

}