<?php

namespace App\Repositories\Admin\User;

interface UserRepositoryInterface
{
    public function all(); // Get all records
    public function find(int $modelId); // Get single record
    public function store(array $request); // Create new record
    public function update(object $model, array $request); // Update existing record
    public function destroy(object $model); // Destroy single record
    public function process(object $data, bool $collection); // Processing given objects
    public function observe(string $class); // Observing model events
}
