<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class FeatureControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateFeatureSuccess()
    {
        $loginData = $this->testCommonLogin();
         return $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/create', [
                "name" => "creates"
            ])
            ->assertStatus(200)->decodeResponseJson();
    }
    public function testCreateInvalidNameType()
    {
        $loginData = $this->testCommonLogin();
         return $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/create', [
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
    public function testTryingToStoreTheFeatureNameWhichAlreadyExists()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/create', [
                "name" => "api/admin/login",
                "id" => 2
            ])
            ->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "name" => [trans('validation.feature.name_unique')],
                ]
            ]);
    }
    public function testRequiredFieldsForFeatureUpdate()
    {
        $loginData = $this->testCommonLogin();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/edit');
        $response->assertStatus(222)->assertJson([
                "status" => false,
                "code" => 222,
                "messages" => [
                    "id" => [ trans('validation.feature.id_required')],
                ]
            ]);
    }
    public function testUpdateFeatureSuccess()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/edit', [
                "name" => "del",
                "id" => 1
            ]);
            $update->assertStatus(200)->assertJson([
                'locale' => 'en',
                'message' => trans('messages.features.updated'),
                'data' => true,
                'status' => true,
            ]);
    }
    public function testUpdateFeatureIdNotFound()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $update = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/edit', [
                "name" => "delete",
                "id" => 10
            ]);
            $data = [
                "success" =>  false,
                "code" => 404,
                "locale" => "en",
                "message" => trans('messages.not_found')
            ];
            $update->assertStatus(404)->assertJson($data);
    }
    public function testFetchFeatureSuccess()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/list', [
                "id" => 1
            ]);
            $response->assertStatus(200)->decodeResponseJson();
    }

    public function testDeleteSuccess()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/delete', [
                "id" => 1
            ]);
            $data = [
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.features.deleted'),
                "data" => 1
            ];
            $response->assertStatus(200)->assertJson($data);
    }

    public function testDeleteFeatureNotFound()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureSuccess();
        $response = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginData['data']['token']])
            ->json('POST', 'api/admin/features/delete', [
                "id" => 11
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
