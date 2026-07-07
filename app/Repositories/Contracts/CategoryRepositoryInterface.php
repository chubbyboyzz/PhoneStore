<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function getAllActive();
    public function getPaginatedCategories(int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
