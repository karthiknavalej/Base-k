<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/admin/register', ['Accept' => 'application/json'])
            ->assertStatus(222)
            ->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => ["Name is required"],
                    "email" => ["Email is required"],
                    "password" => ["Password is required"],
                    "role" => ['Role is required']
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe1@gmail.com",
            "password" => "demo12345",
            "role" => 1
        ];
        $this->withExceptionHandling();
        $this->json('POST', 'api/admin/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)->decodeResponseJson();
    }

    public function testRequiredFieldsForLogin()
    {
        $this->json('POST', 'api/admin/login', ['Accept' => 'application/json'])
            ->assertStatus(222)
            ->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "email" => ["Email is required"],
                    "password" => ["Password is required"],
                ]
            ]);
    }

    public function testWrongCredentialsLogin()
    {
        $userData = [
            "email" => "doe@gmail.com",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)->decodeResponseJson();
    }

    public function testSuccessfulLogin()
    {
        $userData = [
            "email" => "superadmin@gmail.com",
            "password" => "admin123"
        ];
        $this->withExceptionHandling();
        $this->json('POST', 'api/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)->decodeResponseJson();
    }
}
