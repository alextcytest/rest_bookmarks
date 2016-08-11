<?php

namespace AppBundle\Controller;


use AppBundle\Exception\CommentNotFoundException;
use AppBundle\Exception\ExpiredTimeException;

use AppBundle\Exception\InvalidParamException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Comment
 * @package AppBundle\Controller
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class CommentController extends Controller
{

    /**
     * @param Request $request
     * @param integer $bookid
     *
     * @Route("/api/bookmarks/{bookid}/comment", requirements={"bookid" = "[0-9]+"}, name="comment_item_create")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function createCommentAction(Request $request, $bookid)
    {
        $ip = $request->server->get('REMOTE_ADDR');
        $data = (array) json_decode($request->getContent(), true);

        if (!$data || !array_key_exists('text', $data) || !$data['text']) {
            throw new InvalidParamException('No data for insert.');
        }

        //TODO: add validation for comment text

        $bookmarkEntity = $this->getDoctrine()
            ->getRepository('AppBundle:Bookmark')
            ->find($bookid);

        if(!$bookmarkEntity) {
            return new Response('Bookmark not found', Response::HTTP_NOT_FOUND);
        }

        $commentEntity = $this->get('app.comment.service')
            ->store($bookmarkEntity, $ip, $data['text']);

        return new JsonResponse([
            'id' => $commentEntity->getId()
        ]);
    }

    /**
     * @param Request $request
     * @param integer $comid
     *
     * @Route("/api/comments/{comid}", requirements={"comid" = "[0-9]+"}, name="comment_item_update")
     * @Method({"PUT"})
     *
     * @return string
     */
    public function updateCommentAction(Request $request, $comid)
    {
        $ip = $request->server->get('REMOTE_ADDR');

        $data = (array) json_decode($request->getContent(), true);

        if (!$data || !array_key_exists('text', $data) || !$data['text']) {
            throw new InvalidParamException('No data for update.');
        }

        $this->get('app.comment.service')
            ->update($comid, $ip, $data['text']);

        return new Response('', Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     * @param integer $comid
     *
     * @Route("/api/comments/{comid}", requirements={"comid" = "[0-9]+"}, name="comment_item_delete")
     * @Method({"DELETE"})
     *
     * @return string
     */
    public function deleteComment(Request $request, $comid)
    {
        $this->get('app.comment.service')->remove($comid);

        return new Response('', Response::HTTP_NO_CONTENT);
    }

}

