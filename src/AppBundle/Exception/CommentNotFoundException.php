<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CommentNotFoundException
 * @package AppBundle\Exception
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class CommentNotFoundException extends HttpException
{
    /**
     * @param string $message
     */
    public function __construct($message = 'Comment not found')
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}
