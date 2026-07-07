<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Builder $model;

    // Yêu cầu các class con phải cung cấp Model cụ thể
    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $result = $this->findById($id);
        if ($result) {
            $result->update($data);
            return $result;
        }
        return false;
    }

    public function delete(int $id)
    {
        $result = $this->findById($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }
}
