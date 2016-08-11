<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Bookmark;

use AppBundle\Service\UrlService;
use Doctrine\ORM\EntityRepository;

/**
 * Class BookmarkRepository
 * @package AppBundle\Repository
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class BookmarkRepository extends EntityRepository
{
    /**
     * @param int $limit
     *
     * @return mixed
     */
    public function getLastBookmarks($limit = 10)
    {
        $bookQB = $this->createQueryBuilder('book');

        return $bookQB
            ->setMaxResults($limit)
            ->orderBy('book.createAt', 'DESC')
            ->getQuery()
            ->getResult();

    }

    /**
     * @param string $url
     * @param UrlService $urlService
     *
     * @return null|Bookmark
     */
    public function getByUrl($url, UrlService $urlService)
    {
        $bookQB = $this->createQueryBuilder('book');

        return $bookQB
            ->where('book.urlHash = :hash')
            ->setParameter('hash', $urlService->prepareHash($url))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
