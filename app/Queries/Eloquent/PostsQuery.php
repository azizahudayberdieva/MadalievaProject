<?php


namespace App\Queries\Eloquent;


use App\Enums\FileMimeTypes;
use App\Models\Post;
use App\Queries\PostsQueryInterface;

class PostsQuery implements PostsQueryInterface
{
    /**
     * @var int
     */
    protected $category_id;
    /**
     * @var string
     */
    protected $query_search;
    /**
     * @var string
     */
    protected $attachment_mime_type;
    /**
     * @var string
     */
    protected $orderBy = 'created_at';

    /**
     * @var string
     */
    protected $access_types = [];
    /**
     * @var string|null
     */
    protected $status;

    public function __construct(int $category_id = null,
                                array $access_type = [],
                                string $status = null,
                                string $attachment_mime_type = null,
                                string $query_search = null,
                                string $orderBy = null)
    {
        $this->category_id = $category_id;
        $this->attachment_mime_type = $attachment_mime_type;
        $this->query_search = $query_search;
        $this->orderBy = $orderBy;
        $this->access_types = $access_type;
        $this->status = $status;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $orderBy = $this->orderBy ?? 'created_at';
        $direction = $this->orderBy === 'created_at' ? 'desc' : 'asc';

        return Post::with(['category', 'media'])
            ->when($this->category_id, function ($query, $category_id) {
                $query->whereHas('category', function ($q) use ($category_id) {
                    $q->where('id', $category_id);
                    $q->orWhere('parent_id', $category_id);;
                });
            })
            ->when($this->query_search, function ($query, $query_search) {
                $query->where('name', 'like', "%$query_search%");
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->attachment_mime_type, function ($query, $attachment_mime_type) {
                $allowedMimeTypes = FileMimeTypes::getValues();
                $query->whereHas('media', function ($q) use ($attachment_mime_type, $allowedMimeTypes) {
                    $q->whereIn('mime_type', $allowedMimeTypes[$attachment_mime_type]);
                });
            })
            ->whereIn('access_type', $this->access_types)
            ->orderBy($orderBy, $direction)
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    public function setOrderBy(string $orderBy = null): self
    {
        if (!$orderBy) {
            return $this;
        }

        $this->orderBy = $orderBy;
        return $this;
    }

    public function setStatus(string $status = null): self
    {
        $this->status = $status;
        return $this;
    }

    public function setAttachmentMimeType(string $attachmentMimeType = null): self
    {
        $this->attachment_mime_type = $attachmentMimeType;
        return $this;
    }

    public function setQuerySearch(string $qs = null): self
    {
        $this->query_search = $qs;
        return $this;
    }

    public function setCategoryId(int $categoryId = null): self
    {
        $this->category_id = $categoryId;
        return $this;
    }

    public function setAccessTypes(array $accessTypes) : self
    {
        $this->access_types = $accessTypes;
        return $this;
    }
}
