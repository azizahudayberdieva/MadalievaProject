<?php


namespace App\Queries\Eloquent;


use App\Models\Category;
use App\Queries\CategoriesQueryInterface;
use Illuminate\Database\Eloquent\Builder;

class CategoriesQuery implements CategoriesQueryInterface
{
    /**
     * @var bool
     */
    protected $withChildren = false;

    /**
     * @var bool
     */
    protected $withPosts = false;

    /**
     * @var string
     */
    protected $querySearch;

    /**
     * @var array
     */
    protected $relations = [];

    protected $orderBy;

    public function __construct(string $querySearch = null,
                                bool $withChildren = false,
                                bool $withPosts = false,
                                string $orderBy = null)
    {

        $this->querySearch = $querySearch;
        $this->withChildren = $withChildren;
        $this->withPosts = $withPosts;
        $this->orderBy = $orderBy;
    }

    public function execute($perPage = 15, $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $direction = $this->orderBy === 'created_at' ? 'desc' : 'asc';

        $query = $this->getQuery()
            ->when($this->withChildren, function ($query) use (&$relations) {
                $query->where('parent_id', '=', NULL);
            })
            ->when($this->querySearch, function ($query, $qs) {
                $query->where('name', 'like', "%$qs%")
                    ->orWhere('created_at', 'like', "%$qs%");
            })
            ->orderBy($this->orderBy, $direction);

        return $query->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    public function setWithChildren(bool $bool): CategoriesQuery
    {
        $this->withChildren = $bool;
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->getRelations() ? Category::with($this->relations) : Category::query();
    }

    public function getRelations(): array
    {
        if ($this->withChildren) {
            $this->relations[] = 'children';
        }

        if ($this->withPosts) {
            $this->relations[] = 'posts';
        }

        return $this->relations;
    }

    public function setWithPosts(bool $withPosts): CategoriesQuery
    {
        $this->withPosts = $withPosts;
        return $this;
    }

    public function setQuerySearch($querySearch): CategoriesQuery
    {
        $this->querySearch = $querySearch;
        return $this;
    }

    public function setOrderBy($orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }
}
