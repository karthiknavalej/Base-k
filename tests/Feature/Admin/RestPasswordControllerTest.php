<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class RestPasswordControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForresetPassword()
    {
        $this->json('POST', 'api/admin/resetpassword', ['Accept' => 'application/json'])
            ->assertStatus(222)
            ->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "new_password" => ["The new password field is required."],
                    "confirm_password" => ["The confirm password field is required."],
                    "token" => ["The token is required."],
                ]
            ]);
    }
    public function testInvalidToken()
    {
        $userData = [
            "new_password" => "admin123",
            "confirm_password" => "admin123",
            "token" => "wr6LuUU6OMJaRO1NQhKdKxeyH2l6jqLI3YSo8Ve99qnwpl51lzED1iYvgVp"
        ];

        $this->json('POST', 'api/admin/resetpassword', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)->decodeResponseJson();
    }
    public function testTokenExpired()
    {
        $userData = [
            "new_password" => "admin123",
            "confirm_password" => "admin123",
            "token" => "tOcJLabyt7bpzbR7FO1FVodtQsKGPvmn7RewfjT1kADBxWRgxdq4DZVUN0oh"
        ];

        $this->json('POST', 'api/admin/resetpassword', $userData, ['Accept' => 'application/json'])
            ->assertStatus(401)->decodeResponseJson();
    }

    public function testResetPassword()
    {
        $forgotPasswordToken = $this->json(
            'POST',
            'api/admin/forgotpassword',
            ["email" => "superadmin@gmail.com"],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)->decodeResponseJson();
        $userData = [
            "new_password" => "admin123",
            "confirm_password" => "admin123",
            "token" => $forgotPasswordToken['token']
        ];

        $this->json('POST', 'api/admin/resetpassword', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)->decodeResponseJson();
    }
}
