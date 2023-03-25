<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UnauthorizedResponseTag extends AbstractResponseTag
{
    protected int $status = HttpFoundationResponse::HTTP_UNAUTHORIZED;
    protected string $tag = 'unauthorizedResponse';
}
