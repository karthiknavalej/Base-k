<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ModulesRoleMappingControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPermissionsSaveSuccess()
    {
        $loginData = $this->testCommonLogin();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/methods/store', [
            "name" => "api/admin/roles/create"
        ])
        ->assertStatus(200)->decodeResponseJson();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/methods/feature', [
            "feature_method" => [
                [
                    "method_id" => 1,
                    "features_id" => 1
                ]
            ]
        ])
        ->assertStatus(200)->decodeResponseJson();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/modules/create', [
            "name" => "admin",
            "status" => 1
        ])
        ->assertStatus(200)->decodeResponseJson();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/permissions/create', [
            "permissions" => [
                [
                    "module_id" => 1,
                    "role_features" => [
                        [
                            "feature_id" => 1,
                            "roles" => [1,2,3]
                        ]
                    ]
                ]
            ]
        ])
        ->assertStatus(200)->assertJson([
    		"success" => true,
    		"code" => 200,
    		"locale" => "en",
    		"message" => trans('messages.modulerolesmapping.saved'),
        ]);
    }
    public function testRequiredFieldsForPermissionsCreate()
    {
        $loginData = $this->testCommonLogin();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/permissions/create')
        ->assertStatus(222)->assertJson([
            "status" => false,
            "code" => 222,
            "messages" => [
                "permissions" => [trans('validation.modules_roles_mapping.premissions_required')]
            ]
        ]);
    }
}
