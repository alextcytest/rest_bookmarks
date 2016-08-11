<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Class Bookmark
 * @package AppBundle\Entity
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class Bookmark
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $urlHash;

    /**
     * @var DateTime;
     */
    private $createAt;

    /**
     * @var ArrayCollection
     */
    private $comments;

    public function __construct()
    {
        $this->setCreateAt(new \DateTime());
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlHash()
    {
        return $this->urlHash;
    }

    /**
     * @param string $urlHash
     */
    public function setUrlHash($urlHash)
    {
        $this->urlHash = $urlHash;
    }

    /**
     * @return DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param DateTime $createAt
     */
    public function setCreateAt(DateTime $createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     *
     * @return ArrayCollection
     */
    public function addComment(Comment $comment)
    {
        if(!$this->getComments()->contains($comment)) {
            $this->getComments()->add($comment);
        }

        return $this->getComments();
    }

}

