<?php

namespace App\Docs\Strategies\Responses;

use Symfony\Component\HttpFoundation\Response;

class UnprocessableResponseTag extends AbstractResponseTag
{
    protected int $status = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected string $tag = 'unprocessableResponse';

    protected function getContent(): string
    {
        return "{\"message\": \"{$this->getMessage()}\",\"errors\": []}";
    }
}
