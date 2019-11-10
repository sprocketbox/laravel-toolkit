<?php

namespace Sprocketbox\Toolkit\Concerns;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as ResourceCollection;
use League\Fractal\Resource\Item as ResourceItem;

trait TransformsResponses
{
    use RespondsToRequests;

    protected function transform($data, string $transformer, array $meta = []): JsonResponse
    {
        try {
            $manager = Container::getInstance()->make(Manager::class);
            $manager->parseIncludes($this->request()->query('include', ''));
            $manager->parseExcludes($this->request()->query('exclude', ''));
            $manager->getSerializer()->meta($meta);

            $transformer = new $transformer;

            if ($data instanceof Collection) {
                $resource = new ResourceCollection($data, $transformer);
            } else if ($data instanceof LengthAwarePaginator) {
                $resource = new ResourceCollection($data->items(), $transformer);
                $resource->setPaginator(new IlluminatePaginatorAdapter($data));
            } else {
                $resource = new ResourceItem($data, $transformer);
            }

            return $this->response()->json($manager->createData($resource)->toArray());
        } catch (BindingResolutionException $exception) {
            report($exception);
        }
    }
}
