<?php

namespace AppBundle\Entity;


use DateTime;

/**
 * Class Comment
 * @package AppBundle\Entity
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class Comment
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $ip;

    /**
     * @var string
     */
    private $text;

    /**
     * @var DateTime;
     */
    private $createAt;

    /**
     * @var Bookmark
     */
    private $bookmark;

    public function __construct()
    {
        $this->setCreateAt(new \DateTime());
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
    public function getIp()
    {
        return long2ip($this->ip);
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
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
    }

    /**
     * @return Bookmark
     */
    public function getBookmark()
    {
        return $this->bookmark;
    }

    /**
     * @param Bookmark $bookmark
     *
     * @return $this
     */
    public function setBookmark(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;

        return $this;
    }

}
