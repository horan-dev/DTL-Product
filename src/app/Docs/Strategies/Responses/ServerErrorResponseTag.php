<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ServerErrorResponseTag extends AbstractResponseTag
{
    protected int $status = HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR;
    protected string $tag = 'serverErrorResponse';
}
