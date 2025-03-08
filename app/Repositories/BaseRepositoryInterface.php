<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all results in database.
     *
     * @param array $columns
     * @return array
     */
    public function getAll(array $columns = ['*']): array;

    /**
     * Get specific row by id.
     *
     * @param $id
     * @param array $columns
     * @return array|null
     */
    public function getById($id, array $columns = ['*']): ?array;

    /**
     * Get results ORM instance by ids.
     *
     * @param  array  $ids
     * @return array|null
     */
    public function getByIds(array $ids): ?array;

    /**
     * Create a new row via ORM.
     *
     * @param  array  $attributes
     * @return array
     */
    public function create(array $attributes): array;

    /**
     * Find first result or create new record based on attributes.
     *
     * @param  array  $attributes
     * @return array
     */
    public function firstOrCreate(array $attributes): array;

    /**
     * Find a row based on $firstBy or if it does not exist create new row based on attributes.
     *
     * @param  array  $firstBy
     * @param  array  $attributes
     * @return array
     */
    public function firstByOrCreateBy(array $firstBy, array $attributes): array;

    /**
     * Update the model in the database by an identifier.
     *
     * @param $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateById($id, array $attributes = []): bool|int;

    /**
     * Update the model in the database by model object entity.
     *
     * @param Model $model
     * @param array $attributes
     * @return bool|int
     */
    public function updateByEntity(Model $model, array $attributes = []): bool|int;

    /**
     * Update the model in the database by identifiers.
     *
     * @param  array  $ids
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateByIds(array $ids, array $attributes = []): bool|int;

    /**
     * Delete the model in the database by an identifier.
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool;

    /**
     * Find first By Key Value.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function firstByKeyValue($key, $value): bool;

    /**
     * Find a row based on id or Fail and throw an exception.
     *
     * @param $id
     * @return bool
     */
    public function findOrFail($id): bool;

    /**
     * Get the latest results by specific column.
     *
     * @param string $column
     * @return bool
     */
    public function latestBy(string $column): bool;

    /**
     * Create a row if it does not exist otherwise create a row based on attributes.
     *
     * @param array $where
     * @param array $updateOrCreate
     * @return array
     */
    public function updateOrCreate(array $where, array $updateOrCreate): array;

    /**
     * Delete the model in the database by an identifier.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteByIds(array $ids): bool;

    /**
     * Force delete the model in the database by an identifier.
     *
     * @param $id
     * @return bool
     */
    public function forceDeleteById($id): bool;

    /**
     * Use model query function
     *
     * @return Builder
     */
    public function query(): Builder;
}
