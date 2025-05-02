<?php

declare(strict_types=1);

namespace App\Repositories\Admin\Role;

// Model
use App\Models\Role;
// Resource
use App\Http\Resources\Admin\RoleResource;
// Exception
use App\Exceptions\ModelNotFoundException;
// Others
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var model
    */
    protected $model;

    /**
     * @method __construct
    */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     *
     * @method all
     *
     * @return Illuminate\Database\Eloquent\Collection
     *
    */
    public function all(): ?Collection
    {
        return $this->model->all();
    }

    /**
     * Find record by Id
     *
     * @method find
     *
     * @param  int $modelId
     *
     * @return App\Models\Role
     *
    */
    public function find(int $modelId): ?Role
    {
        $model = $this->model->find($modelId);
        if (!$model) {
            throw new ModelNotFoundException();
        }
        return $model;
    }

    /**
     * Create new record
     *
     * @method store
     *
     * @param  array $request
     *
     * @return App\Models\Role
     *
    */
    public function store(array $request): ?Role
    {
        return $this->model->create($request);
    }

    /**
     * Update existing record
     *
     * @method update
     *
     * @param  object $model
     *
     * @param  array $request
     *
     * @return bool
     *
    */
    public function update(object $model, array $request): bool
    {
        return $model->update($request);
    }

    /**
     * Permanently destroy record by id
     *
     * @method destroy
     *
     * @param  object $model
     *
     * @return bool
     *
    */
    public function destroy(object $model): bool
    {
        return $model->forceDelete();
    }

    /**
    * process objects
    *
    * @method process
    *
    * @param  object $model
    *
    * @param  bool $collection
    *
    * @return object
    *
    */
    public function process(object $data, bool $collection = false): ?object
    {
        if ($collection) {
            return RoleResource::collection($data);
        }
        return new RoleResource($data);
    }

    /**
    * return observer
    *
    * @method observe
    *
    * @return App\Models\Role
    *
    */
    public function observe(string $class): ?Role
    {
        return $this->model->observe($class);
    }
}
