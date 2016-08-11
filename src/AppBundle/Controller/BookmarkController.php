<?php

namespace AppBundle\Controller;


use AppBundle\Exception\InvalidParamException;
use JMS\Serializer\SerializationContext;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Bookmark
 * @package AppBundle\Controller
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class BookmarkController extends Controller
{
    /**
     * @param Request $request
     * @Route("/api/bookmarks", name="bookmarks_latest")
     *
     * @return string
     */
    public function getBookmarksAction(Request $request)
    {
        $bookmarkRepository = $this->getDoctrine()->getRepository('AppBundle:Bookmark');
        $bookmarks = $bookmarkRepository->getLastBookmarks();

        $jms = $this->get('jms_serializer');
        $bookmarksJson = $jms->serialize(
            $bookmarks,
            'json',
            SerializationContext::create()->setGroups(array('get_bookmarks'))
        );

        $response = new Response($bookmarksJson);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @Route("/api/bookmark/{url}", requirements={"url"=".+"}, name="bookmark_item")
     *
     * @return string
     */
    public function getBookmarkAction(Request $request, $url)
    {
        $urlService = $this->get('app.url.service');

        $bookmarkEntity = $this->getDoctrine()
            ->getRepository('AppBundle:Bookmark')
            ->getByUrl($url, $urlService);

        if(!$bookmarkEntity) {
            return new Response('Bookmarks not found', Response::HTTP_NOT_FOUND);
        }

        $jms = $this->get('jms_serializer');
        $bookmarkJson = $jms->serialize(
            $bookmarkEntity,
            'json',
            SerializationContext::create()->setGroups(array('get_bookmarks'))
        );

        $response = new Response($bookmarkJson);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @Route("/api/bookmark", name="bookmark_item_create")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function createBookmarkAction(Request $request)
    {
        $data = (array) json_decode($request->getContent(), true);

        if (!$data || !array_key_exists('url', $data) || !$data['url']) {
            throw new InvalidParamException('URL param is empty.');
        }

        $bookmarkEntity = $this->get('app.bookmark.service')->store($data['url']);

        return new JsonResponse([
            'id' => $bookmarkEntity->getId()
        ]);
    }
}
