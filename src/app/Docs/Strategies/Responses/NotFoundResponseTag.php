<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response;

class NotFoundResponseTag extends AbstractResponseTag
{
    protected int $status = Response::HTTP_NOT_FOUND;
    protected string $tag = 'notFoundResponse';
}
