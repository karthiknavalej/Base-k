<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class MethodControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateMethodSuccess()
    {
        $loginData = $this->testCommonLogin();
         return $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/store', [
                "name" => "api/admin/login",
            ])
            ->assertStatus(200)->decodeResponseJson();
    }
    public function testCreateMethodInvalidNameType()
    {
        $loginData = $this->testCommonLogin();
         return $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/store', [
                "name" => 1,
            ])
            ->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => [ trans('validation.register.name_string')],
                ]
            ]);
    }
    public function testStoreDuplicateMethodName()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateMethodSuccess();
        $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/store', [
                "name" => "api/admin/login",
                "id" => 2
            ])
            ->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => [trans('validation.method.name_unique')],
                ]
            ]);
    }
    public function testRequiredFieldsForMethodCreate()
    {
        $loginData = $this->testCommonLogin();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/store');
        $response->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => [ trans('validation.register.name_required')],
                ]
            ]);
    }
    public function testRequiredFieldsForMethodUpdate()
    {
        $loginData = $this->testCommonLogin();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/update');
        $response->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "id" => [ trans('validation.method.id_required')],
                ]
            ]);
    }
    public function testUpdateMethodSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCreateMethodSuccess();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/update', [
                "name" => "api/admin/delete",
                "id" => $create['data']['id']
            ]);
            $data = [
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.methods.updated'),
                "data" => 1
                ];
            $update->assertStatus(200)->assertJson($data);
    }
    public function testUpdateMethodInvalidId()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateMethodSuccess();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/update', [
                "name" => "api/admin/delete",
                "id" => 2
            ]);
            $data = [
                "success" =>  false,
                "code" => 404,
                "locale" => "en",
                "message" => trans('messages.not_found')
            ];
            $update->assertStatus(404)->assertJson($data);
    }
    public function testFetchMethodSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCreateMethodSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/fetch', [
                "id" => $create['data']['id']
            ]);
            $response->assertStatus(200)->decodeResponseJson();
    }

    public function testFetchMethodInvalidId()
    {
        $loginData = $this->testCommonLogin();
         $this->testCreateMethodSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/fetch', [
                "id" => 2
            ]);
            $data = [
                "success" =>  false,
                "code" => 404,
                "locale" => "en",
                "message" => trans('messages.not_found')
            ];
            $response->assertStatus(404)->assertJson($data);
    }
    public function testMethodDeleteSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCreateMethodSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/delete', [
                "id" => $create['data']['id']
            ]);
            $data = [
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.methods.deleted'),
                "data" => 1
            ];
            $response->assertStatus(200)->assertJson($data);
    }

    public function testDeleteMethodNotFound()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateMethodSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/methods/delete', [
                "id" => 3
            ]);
            $data = [
                "success" =>  false,
                "code" => 404,
                "locale" => "en",
                "message" => trans('messages.not_found')
            ];
            $response->assertStatus(404)->assertJson($data);
    }
}
