<?php

namespace App\Docs\Strategies;

// use Knuckles\Scribe\Extraction\ExtractedEndpointData;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class AddPaginationParameters extends Strategy
{
    use ParamHelpers;
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules = []): ?array
    {
        $methodDocBlock = RouteDocBlocker::getDocBlocksFromRoute($endpointData->route)['method'];
        $tags = $methodDocBlock->getTagsByName('usesPagination');

        if (empty($tags)) {
            // Doesn't use pagination
            return [];
        }

        $defaultPageSize = config('json-api-paginate.default_size');

        return [
            'page[number]' => [
                'description' => 'Page number to return.',
                'required' => false,
                'example' => 1,
            ],
            'page[size]' => [
                'description' => "Number of items to return in a page. Defaults to $defaultPageSize.",
                'required' => false,
                'example' => null, // So it doesn't get included in the examples
            ],
        ];
    }
}
