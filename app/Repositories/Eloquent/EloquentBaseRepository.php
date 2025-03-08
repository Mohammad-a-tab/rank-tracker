<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class EloquentBaseRepository implements BaseRepositoryInterface
{
    /**
     * @var $model
     * @var $itemsPerPage
     */
    protected $model;
    protected $itemsPerPage;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->makeModel();

        $this->itemsPerPage = config('global.items_per_page', 15);
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model(): mixed;

    /**
     * @return Model
     * @throws BindingResolutionException
     * @throws \Exception
     */
    public function makeModel(): Model
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of " . Model::class);
        }

        return $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function getAll(array $columns = ['*']): array
    {
        return $this->model->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function getById($id, array $columns = ['*']): ?array
    {
        $row = $this->model->find($id, $columns);

        return is_null($row) ? null : $row;
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): array
    {
        return $this->model
            ->whereIn('id', $ids)
            ->orderBy('id', 'ASC')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): array
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(array $attributes): array
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @inheritDoc
     */
    public function firstByOrCreateBy(array $firstBy, array $attributes): array
    {
        return $this->model->firstOrCreate($firstBy, $attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateById($id, array $attributes = []): bool|int
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateByEntity(Model $model, array $attributes = []): bool|int
    {
        return $model->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateByIds(array $ids, array $attributes = []): bool|int
    {
        return $this->model->whereIn('id', $ids)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        return $this->model->find($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function firstByKeyValue($key, $value): bool
    {
        return $this->model->where($key, $value)->first();
    }

    /**
     * @inheritDoc
     */
    public function findOrFail($id): bool
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function latestBy(string $column = "created_at"): bool
    {
        return $this->model->latest($column)->first();
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(array $where, array $updateOrCreate): array
    {
        return $this->model->updateOrCreate($where, $updateOrCreate);
    }

    /**
     * @inheritDoc
     */
    public function deleteByIds(array $ids): bool
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * @inheritDoc
     */
    public function forceDeleteById($id): bool
    {
        return $this->model->where('id', $id)->forceDelete();
    }

    /**
     * @inheritDoc
     */
    public function query(): Builder
    {
        if ($this->model instanceof Builder){
            return  $this->model;
        }

        return $this->model->query();
    }
}
