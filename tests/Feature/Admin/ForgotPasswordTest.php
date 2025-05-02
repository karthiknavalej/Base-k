<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForForgotPassword()
    {
        $this->json('POST', 'api/admin/login', ['Accept' => 'application/json'])
            ->assertStatus(222)
            ->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "email" => ["Email is required"],
                ]
            ]);
    }
    public function testUserNotFound()
    {
        $userData = [
            "email" => "nishanthreddy31@gmail.com"
        ];

        $this->json('POST', 'api/admin/forgotpassword', $userData, ['Accept' => 'application/json'])
            ->assertStatus(404)->decodeResponseJson();
    }

    public function testForgotPassword()
    {
        $userData = [
            "email" => "superadmin@gmail.com"
        ];

        $this->json('POST', 'api/admin/forgotpassword', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)->decodeResponseJson();
    }
}
