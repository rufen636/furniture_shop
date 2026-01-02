<?php

namespace App\Http\Resources\Traits;

trait WithPagination
{
    /**
     * Создает ресурс с пагинацией
     */
    public static function paginatedCollection($paginator)
    {
        // Используем items() для получения коллекции элементов
        $collection = static::collection($paginator->items());

        return $collection->additional([
            'meta' => static::paginationMeta($paginator)
        ]);
    }

    /**
     * Генерирует метаданные пагинации
     */
    public static function paginationMeta($paginator)
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'links' => $paginator->links()->elements,
        ];
    }
}
