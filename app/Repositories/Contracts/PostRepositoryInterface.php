<?php
namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function getAll(int $perPage = 15);
    public function findById(int $id): Post;
    public function create(array $data): Post;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function findBySlug(string $slug);
    public function getPublished(int $perPage = 9);
}
