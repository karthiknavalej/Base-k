<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        Artisan::call('db:seed');
    }
    public function testCommonLogin()
    {
        $loginData = $this->withHeaders([
            'Content-Type' => 'application/json'])
             ->json(
                 'POST',
                 'api/admin/login',
                 ['email' => 'superadmin@gmail.com',
                 'password' => 'admin123'],
                 ['Accept' => 'application/json'
                 ]
             )
             ->assertStatus(200)->decodeResponseJson();
            return $loginData;
    }
}
