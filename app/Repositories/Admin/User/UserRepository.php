<?php

declare(strict_types=1);

namespace App\Repositories\Admin\User;

// Model
use App\Models\User;

// Resource
use App\Http\Resources\Admin\UserResource;

// Exception
use App\Exceptions\ModelNotFoundException;

// Others
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var model
    */
    protected $model;

    /**
     * @method __construct
    */
    public function __construct(User $model)
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
     * @return App\Models\User
     *
    */
    public function find(int $modelId): ?User
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
     * @return App\Models\User
     *
    */
    public function store(array $request): ?User
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
            return UserResource::collection($data);
        }
        return new UserResource($data);
    }

    /**
    * return observer
    *
    * @method observe
    *
    * @return App\Models\User
    *
    */
    public function observe(string $class): ?User
    {
        return $this->model->observe($class);
    }
}
