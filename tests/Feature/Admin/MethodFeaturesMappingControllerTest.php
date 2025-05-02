<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class MethodFeaturesMappingControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateFeatureMethodSuccess()
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
            ->assertStatus(200)->assertJson([
                "success" => true,
                "code" => 200,
                "locale" => "en",
                "message" => trans('messages.methodsFeatureMapping.saved'),
            ]);
    }

    public function testInsertDuplicateData()
    {
        $loginData = $this->testCommonLogin();
        $this->testCreateFeatureMethodSuccess();
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
        ->assertStatus(222)->assertJson([
            "status" => false,
            "code" => 222,
            "messages" => [
                "feature_method.0.method_id" => [ trans('validation.methods_features_mapping.method_id_unique')]
            ]
        ]);
    }

    public function testRequiredFieldsForMethodFeatureCreate()
    {
        $loginData = $this->testCommonLogin();
        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $loginData['data']['token']])
        ->json('POST', 'api/admin/methods/feature')
        ->assertStatus(222)->assertJson([
            "status" => false,
            "code" => 222,
            "messages" => [
                "feature_method" => [ trans('validation.methods_features_mapping.feature_method_required')],
            ]
        ]);
    }
}
