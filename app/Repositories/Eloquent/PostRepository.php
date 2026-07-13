<?php
namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    protected Post $model;

    public function __construct(Post $model) { $this->model = $model; }

    public function getAll(int $perPage = 15) { return $this->model->latest()->paginate($perPage); }

    public function findById(int $id): Post { return $this->model->findOrFail($id); }

    public function create(array $data): Post { return $this->model->create($data); }

    public function update(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->findOrFail($id)->delete();
    }
}
