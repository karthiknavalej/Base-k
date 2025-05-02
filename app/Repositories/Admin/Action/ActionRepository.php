<?php

declare(strict_types=1);

namespace App\Repositories\Admin\Action;

use App\Models\Action;
use Illuminate\Database\Eloquent\Collection;

// Resource
use App\Http\Resources\Admin\ActionResource;

// Exception
use App\Exceptions\ModelNotFoundException;

class ActionRepository implements ActionRepositoryInterface
{
    /**
     * @type model
     */
    protected $model;

    /**
     * @method __construct
     */
    public function __construct()
    {
        $this->model = new Action();
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
     * @return App\Models\Action
     *
    */
    public function find(int $modelId): ?Action
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
     * @return App\Models\Action
     *
    */
    public function store(array $request): ?Action
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
            return ActionResource::collection($data);
        }
        return new ActionResource($data);
    }

    /**
    * return observer
    *
    * @method observe
    *
    * @return App\Models\Action
    *
    */
    public function observe(string $class): ?Action
    {
        return $this->model->observe($class);
    }
}
