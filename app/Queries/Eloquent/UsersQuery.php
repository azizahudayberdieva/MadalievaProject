<?php


namespace App\Queries\Eloquent;


use App\Models\User;
use App\Queries\UsersQueryInterface;
use Illuminate\Database\Eloquent\Builder;

class UsersQuery implements UsersQueryInterface
{
    protected $relations = [];

    protected $email;

    protected $name;

    protected $querySearch;

    public function execute($perPage = 15, $page = 1)
    {
        return User::when($this->email, function ($query) {
                return $query->where('email', $this->email);
            })
            ->when($this->name, function ($query) {
                return $query->where('name', $this->name);
            })
            ->when($this->querySearch, function ($query) {
                return $query->where('name', 'like', "%$this->querySearch%")
                    ->orWhere('email', 'like', "%$this->querySearch%");
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    public function getQuery(): Builder
    {
        return $this->getRelations() ? User::with($this->relations) : User::query();
    }

    /**
     * @param mixed $email
     * @return UsersQuery
     */
    public function setEmail($email = null)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $name
     * @return UsersQuery
     */
    public function setName(string $name = null)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $querySearch
     * @return UsersQuery
     */
    public function setQuerySearch($querySearch = null)
    {
        $this->querySearch = $querySearch;
        return $this;
    }

}
