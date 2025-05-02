<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ModuleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCommonCreateModule()
    {
        $loginData = $this->testCommonLogin();
         return $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/create', [
                "name" => "admin",
                "status" => 1
            ])
            ->assertStatus(200)->decodeResponseJson();
    }
    public function testRequiredFieldsForStoringData()
    {
        $loginData = $this->testCommonLogin();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/create');
            $response->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => ["Name is required"],
                    "status" => ["status is required."],
                ]
            ]);
    }

    public function testUpdateModuleSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCommonCreateModule();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/update', [
                "name" => "module",
                "id" => $create['data']['id']
            ]);
            $data = [
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.modules.updated'),
                "data" => true
                ];
            $update->assertStatus(200)->assertJson($data);
    }

    public function testUpdateModuleInvalidId()
    {
        $loginData = $this->testCommonLogin();
        $this->testCommonCreateModule();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/update', [
                "name" => "module",
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

    public function testFetchModuleSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCommonCreateModule();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/list', [
                "id" => $create['data']['id']
            ]);
            $response->assertStatus(200)->decodeResponseJson();
    }

    public function testFetchModuleInvalidId()
    {
        $loginData = $this->testCommonLogin();
        $this->testCommonCreateModule();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/list', [
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

    public function testDeleteModuleSuccess()
    {
        $loginData = $this->testCommonLogin();
        $create = $this->testCommonCreateModule();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/delete', [
                "id" => $create['data']['id']
            ]);
            $data = [
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.modules.deleted'),
                "data" => 1
                ];
            $response->assertStatus(200)->assertJson($data);
    }

    public function testDeleteModuleInvalidId()
    {
        $loginData = $this->testCommonLogin();
        $this->testCommonCreateModule();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/modules/delete', [
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
}
