<?php

namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function attempt(array $request); // Auth attempt with email and password
    public function createAccessToken(object $user); // Create New Access Token
    public function createPasswordToken(object $user); // Create user password token
    public function store(array $request); // Create new user record
    public function isPasswordTokenExpired(object $user); // Check password token expired
    public function updatePassword(object $user, array $request); // update password
    public function findByEmail(string $email); // find user by email id
    public function findByToken(string $token); // find user by token
    public function process(object $data, bool $collection); // Processing given objects
    public function observe(string $class); // Observing model events
    public function checkUserDeviceTokenExists(array $deviceDetails);// Find record by device details and userId
    public function destroyDeviceTokensByUserId(int $userId); //delete record by userId
    public function storeDeviceDetails(array $request);// Create new device details record
}
