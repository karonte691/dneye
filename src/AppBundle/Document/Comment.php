<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\CommentBundle\Document\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document
 * @MongoDB\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * Author of the comment
     *
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="comment")
     */
    protected $author;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @MongoDB\ReferenceOne(targetDocument="Thread")
     */
    protected $thread;

    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }
}
