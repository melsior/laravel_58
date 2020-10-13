<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
/**
 * Class BlogPostRepository
 * @package App\Repositories
 */
class BlogPostRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }
    /**
     * Получить список статей для вывода в списке
     *(Админка)
     *
     *  @return LenghtAwarePaginator
     */
    public function  getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];
        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                'user:id,name',
            ])
            ->paginate(25);

        return $result;
    }

    /**
     * Получить модель для редактирования в админке.
     * @param int $id
     * @return Model
     */
    public  function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
}
