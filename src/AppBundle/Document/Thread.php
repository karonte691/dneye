<?php

namespace AppBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\CommentBundle\Document\Thread as BaseThread;

/**
 * @MongoDB\Document
 * @MongoDB\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{
    /**
     * item
     *
     * @MongoDB\ReferenceOne(targetDocument="Item", inversedBy="Thread")
     */
    protected $item;

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
}
