<?php

namespace AppBundle\Service;


use AppBundle\Entity\Bookmark;
use Doctrine\ORM\EntityManager;

/**
 * Class BookmarkService
 * @package AppBundle\Service
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class BookmarkService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UrlService
     */
    private $urlService;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, UrlService $urlService)
    {
        $this->entityManager = $entityManager;
        $this->urlService    = $urlService;
    }

    /**
     * @param string $url
     *
     * @return Bookmark
     */
    public function store($url)
    {
        $bookmarkEntity = $this->entityManager
            ->getRepository('AppBundle:Bookmark')
            ->getByUrl($url, $this->urlService);

        if(!$bookmarkEntity) {
            $bookmarkEntity = new Bookmark();
            $bookmarkEntity
                ->setUrl($url)
                ->setUrlHash($this->urlService->prepareHash($url));

            $this->entityManager->persist($bookmarkEntity);
            $this->entityManager->flush($bookmarkEntity);
        }

        return $bookmarkEntity;
    }
}
