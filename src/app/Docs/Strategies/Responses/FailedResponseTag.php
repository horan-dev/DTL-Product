<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response;

class FailedResponseTag extends AbstractResponseTag
{
    protected int $status = Response::HTTP_BAD_REQUEST;
    protected string $tag = 'failedResponse';
}
