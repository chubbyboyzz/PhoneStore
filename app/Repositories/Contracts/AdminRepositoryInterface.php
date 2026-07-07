<?php

namespace App\Repositories\Contracts;

interface AdminRepositoryInterface
{
    public function getPaginated(int $perPage = 10);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
