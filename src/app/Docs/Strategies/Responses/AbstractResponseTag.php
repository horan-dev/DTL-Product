<?php

namespace App\Docs\Strategies\Responses;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Strategy;
use Mpociot\Reflection\DocBlock\Tag;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseTag extends Strategy
{
    protected ?string $message = null;
    protected int $status = Response::HTTP_BAD_REQUEST;
    protected string $tag = '';

    protected function getContent(): string
    {
        return "{\"message\": \"{$this->getMessage()}\"}";
    }

    protected function getMessage(): string
    {
        return match ($this->status) {
            Response::HTTP_BAD_REQUEST => 'Operation failed.',
            Response::HTTP_FORBIDDEN => 'Forbidden.',
            Response::HTTP_NOT_FOUND => 'Not Found.',
            Response::HTTP_OK => 'Operation succeeded.',
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error.',
            Response::HTTP_UNAUTHORIZED => 'Unauthorized.',
            Response::HTTP_UNPROCESSABLE_ENTITY => 'Validation failed.',
            default => ''
        };
    }

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $docBlocks = RouteDocBlocker::getDocBlocksFromRoute($endpointData->route);
        $methodDocBlock = $docBlocks['method'];

        return $this->getDocBlockResponses($methodDocBlock->getTags());
    }

    /**
     * Get the response from the docblock if available.
     *
     * @param Tag[] $tags
     *
     * @return array|null
     */
    public function getDocBlockResponses(array $tags): ?array
    {
        $responseTags = array_values(
            array_filter($tags, function ($tag) {
                return $tag instanceof Tag && strtolower($tag->getName()) === strtolower($this->tag);
            })
        );

        if (empty($responseTags)) {
            return null;
        }

        $responses = array_map(function (Tag $responseTag) {
            return [
                'content' => $this->getContent(),
                'status' => $this->status,
                'description' => $this->status . ', ' . $this->getMessage()
            ];
        }, $responseTags);

        return $responses;
    }
}
