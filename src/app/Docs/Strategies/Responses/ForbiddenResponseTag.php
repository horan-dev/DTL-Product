<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response;

class ForbiddenResponseTag extends AbstractResponseTag
{
    protected int $status = Response::HTTP_FORBIDDEN;
    protected string $tag = 'forbiddenResponse';
}
