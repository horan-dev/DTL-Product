<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response;

class OkResponseTag extends AbstractResponseTag
{
    protected int $status = Response::HTTP_OK;
    protected string $tag = 'okResponse';

    protected function getContent(): string
    {
        return "{\"message\": \"{$this->getMessage()}\",\"data\": []}";
    }
}
