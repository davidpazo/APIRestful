<?php

namespace App\Traits;

use Dotenv\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /** ver 1 */
    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);
        return $this->successResponse($instance, $code);
    }

    /** ver todos */
    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    /** Ver mensajes */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }
    /** respuesta satisfactoria */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    /** Para filtrar por distintos campos se usa este método*/
    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);
            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }

    /*** metodo para ordenar los resultados de las colecciones ***/
    protected function sortData(Collection $collection, $transformer)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    /** Para paginar los resultados, mostrar x resultados por pagina*/
    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perpage = 15;
        if (request()->has('per_page')) {
            $perpage = (int)request()->per_page;
        }
        $results = $collection->slice(($page - 1) * $perpage)->values();
        $paginated = new LengthAwarePaginator(
            $results,
            $collection->count(),
            $perpage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);
        $paginated->appends(request()->all());
        return $paginated;
    }

    /** Para transformar los datos recibidos de la bd */
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }
    /** sistema de cache para no cargar la bd */
    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);
        $fullurl ="{$url}?{$queryString}";

        return Cache::remember($fullurl, 30/60, function() use ($data) {
            return $data;
        });
    }

    /**protected function getAppNamespace()
     * {
     * return Container::getInstance()->getNamespace();
     * }*/
}