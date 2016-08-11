<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bookmark;
use AppBundle\Entity\Comment;
use AppBundle\Exception\CommentNotFoundException;
use AppBundle\Exception\ExpiredTimeException;
use Doctrine\ORM\EntityManager;

/**
 * Class CommentService
 * @package AppBundle\Service
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class CommentService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Bookmark $bookmarkEntity
     * @param string $ip
     * @param string $text
     *
     * @return Comment
     */
    public function store(Bookmark $bookmarkEntity, $ip, $text)
    {
        $commentEntity = new Comment();
        $commentEntity->setIp($ip);
        $commentEntity->setText($text);
        $commentEntity->setBookmark($bookmarkEntity);

        $this->entityManager->persist($commentEntity);
        $this->entityManager->flush($commentEntity);

        return $commentEntity;
    }

    /**
     * @param int $id
     * @param string $ip
     * @param string $text
     *
     * @return Comment|null|object
     * @throws ExpiredTimeException
     */
    public function update($id, $ip, $text)
    {
        $commentEntity = $this->entityManager->find('AppBundle:Comment', $id);

        if(!$commentEntity) {
            throw new CommentNotFoundException();
        }

        $createAt    = $commentEntity->getCreateAt();
        $cirrentTime = new \DateTime();
        $interval    = $createAt->diff($cirrentTime);

        if(($ip != $commentEntity->getIp()) || ($interval->h >= 1)) {
            throw new ExpiredTimeException('Comment created more than hour ago.');
        }

        $commentEntity->setText($text);

        $this->entityManager->persist($commentEntity);
        $this->entityManager->flush($commentEntity);

        return $commentEntity;
    }

    /**
     * @param int $id
     *
     * @throws ExpiredTimeException
     */
    public function remove($id)
    {
        $commentEntity = $this->entityManager->find('AppBundle:Comment', $id);

        if(!$commentEntity) {
            throw new CommentNotFoundException();
        }

        $this->entityManager->remove($commentEntity);
        $this->entityManager->flush();
    }
}
