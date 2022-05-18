<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function test_the_game_route_returns_a_created_response()
    {
        $response = $this->post('/api/game');

        $response->assertStatus(201);
    }

    public function test_the_game_route_returns_a_payload_with_game_data()
    {
        $this->seed();

        $expectedJSONResponse = [
            "game" => [],
            "questions" => [
                "*" => [
                    "answers" => []
                ]
            ]
        ];

        $response = $this->post('/api/game');

        $response->assertJsonStructure($expectedJSONResponse);
    }
}
